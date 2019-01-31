<!--------------Get tableID to INSERT order into table_order Database----------->
<?php
include("config.php");


?>
<!------------------------------Send Order------------------------------>
<?php

if(isset($_POST['sendOrder'])){
  include("time.php");
  $tableID = $_POST['tableID'];

  //Insert a record into orders database
  $sql_orders = "SELECT * FROM table".$tableID."_order";
  $result_orders=$conn->query($sql_orders);
  //If no record in table_order
  if($result_orders->num_rows < 1)
  {
    $sql_orders1 = "INSERT INTO orders (tableID,date,time)VALUES('$tableID','".date("Y/m/d")."','".date("H:i:s")."')";
    $result_orders1 = $conn->query($sql_orders1);
  }

  $sql = "INSERT INTO table".$tableID."_order (foodid, foodname, price, quantity, date, time) VALUES";
  for ($i=0; $i < count($_POST['foodid']); $i++) {
    $sql .= "('".$_POST['foodid'][$i]."', '".$_POST['foodname'][$i]."', '".$_POST['price'][$i]."', '".$_POST['quantity'][$i]."','".date("Y/m/d")."','".date("H:i:s")."')";
    if ($i<count($_POST['foodid']) - 1) {
       $sql .= ',';
    }
  }

  $result = $conn->query($sql);

  //Change table status to 1
  $sql_status = "UPDATE tablemng SET status = 1 WHERE tableID = '$tableID'";
  $result_status = $conn->query($sql_status);

  header("Location: order_page.php?tableID=".$tableID);

}
?>

<!-------------------------Delete Order detail--------------------------->

<?php

if(isset($_POST['delete'])){
  $tableID = $_POST['tableID'];
  $foodid = $_POST['delete'];

  $sql = "DELETE from table".$tableID."_order where foodid = $foodid";
  $result = $conn->query($sql);

  //Check if the table still has food ordered after delete
  $sql = "SELECT * FROM table".$tableID."_order";
  $result = $conn->query($sql);

  if($result->num_rows < 1){
    //If empty change the table status back to 0
    $sql_status = "UPDATE tablemng SET status = 0 WHERE tableID = '$tableID'";
    $conn->query($sql_status);
    //If empty delete the record of same tableID from orders
    $sql_empty = "DELETE FROM orders WHERE tableID = '$tableID'";
    $conn->query($sql_empty);
  }

  header("Location: order_page.php?tableID=".$tableID);

}

?>




<?php

if (isset($_POST['insertOrder']))
{
  $id = $_POST['posID'];
  $sql="SELECT foodid,foodname,price FROM menu WHERE foodid = $id";
  $results = $conn->query($sql);

//---------------Select table ID--------------//
  $tableID = $_POST['tableID'];

//--------------------------Display Append food detail-----------------------//
  if ($results->num_rows > 0)
  {

    while($row = $results->fetch_assoc())
    {

      echo "<div class=\"".$row["foodid"]."\" id='".$row["foodid"]."'>
      <input value='".$row["foodid"]."' class=\"append1 foodid\" name=\"foodid[]\" id='foodid' readonly><input value='".$row["foodname"]."' class=\"append2 foodname\" name=\"foodname[]\" id='foodname' readonly><input value='".$row["price"]."' class=\"append3 price".$row["foodid"]."\" name=\"price[]\" id='price' readonly><input class=\"append4 quantity".$row["foodid"]."\" type=\"number\" name=\"quantity[]\" id='quantity' min='1' value='1'><input value=\"delete\" type=\"button\" class=\"delete1\" id='delete'></div>";

    }

   }

}


?>

<?php
if(isset($_POST['pay']))
{

$tableID = $_POST['tableID'];

header("Location: payment.php?tableID=".$tableID);
}


?>

<!-------------------Insert data into Payment History----------------------->

<?php
if(isset($_POST['completePayment']))
{

  include("time.php");

  $tableID = $_POST['tableID'];
  $totalprice = $_POST['totalprice'];
  $payAmount = $_POST['payAmount'];
  $payChange = $payAmount-$totalprice;

  if($payChange<0)
  {
   echo "<script>
  alert('INSUFFICIENT PAYMENT');
  window.location.href='payment.php?tableID=".$tableID."';
  </script>";
  }

  else
  {

//----------------------Get current tableNum from tablemng----------------------//
$sql_getNum = "SELECT tableNum FROM tablemng WHERE tableID = '$tableID'";
$result_getNum = $conn->query($sql_getNum);
$row = $result_getNum->fetch_assoc();
$tableNum = $row['tableNum'];

//--------------------Insert data into payment history table----------------------//
    $sql_payhistory1 = "INSERT INTO payhistory(tableID,tableNum,date,time,total,payAmt,payChange)VALUES('$tableID','$tableNum','".date("Y/m/d")."','".date("H:i:s")."','$totalprice','$payAmount','$payChange')";
    $result_payhistory1 = $conn->query($sql_payhistory1);


  //--------Insert all order detail into payment database with the payid----------//
  $sql_payment = "SELECT payID FROM payhistory ORDER BY payID DESC LIMIT 1";
  $result_payment = $conn->query($sql_payment);
  $pay = $result_payment->fetch_assoc();
  $payID = $pay['payID'];

  $sql_payment1 = "SELECT a.foodid,a.foodname, date, SUM(a.price) AS stackedPrice,SUM(a.quantity) AS stackedQty FROM table".$tableID."_order AS a GROUP BY a.foodid";
  $result_payment1 = $conn->query($sql_payment1);


 if ($result_payment1->num_rows > 0)
  {

    while($row = $result_payment1->fetch_assoc())
    {
      $foodid = $row['foodid'];
      $foodname = $row['foodname'];
      $price = $row['stackedPrice'];
      $quantity = $row['stackedQty'];
      $date = $row['date'];

      $sql_payment2 = "INSERT INTO payment(payID,foodid, foodname, price, quantity, date) VALUES";
      for ($i=0; $i < count($row['foodid']); $i++) {
        $sql_payment2 .= "(  '".$payID."','".$foodid."', '".$foodname."', '".$price."', '".$quantity."', '".$date."')";
        if ($i<count($row['foodid']) - 1) {
           $sql_payment2 .= ',';
        }
      }

      $result_payment2 = $conn->query($sql_payment2);

    }

  }

  //Clear the data from orders and table_order
  $sql_clear = "DELETE FROM orders WHERE tableID = '$tableID'";
  $result_clear = $conn->query($sql_clear);
  $sql_clear = "DELETE FROM table".$tableID."_order";
  $result_clear = $conn->query($sql_clear);
  //Set the table status back to 0
  $sql_table = "UPDATE tablemng SET status = 0 WHERE tableID = '$tableID' ";
  $conn->query($sql_table);

  echo "<script>window.open('print_receipt.php?pdf=1&payID=".$payID."', '_blank')</script>";
  echo "<script>window.location.href='index.php'</script>";
  }
}





?>




<!----------------------------Remove append thing------------------------------>
<script>

  $(".delete1").click(function()
  {
    var id = $(this).parent().attr('id');

    check_data(id, foodlist);
    $(this).parent().remove();

    console.log(id);
    console.log(foodlist);


  });

</script>

<script>
function check_data(id, list)
  {
    for(i=0; i<list.length; i++)
    {

      if(list[i].id === id)
      {
        console.log(list[i]);
        list.splice(i,1);

       return true;

      }
    }

  return false;
  }

</script>

<!---------------------------Quantity Change Price Change----------------------------->
<script type="text/javascript">
//-------------------Detect the input change------------------------
$("input").change(function()
 {
  var target = $(this).parent().attr('class');

  //---------------------get total price---------------------------
  var sum = $(".price"+target).attr('value');

  $('.quantity'+target).each(function()
  {

    var num = $('.quantity'+target).val();

    if(num!=0)
    {
      sum = sum*num;
//--------------------------Round off the price------------------------
      sum  = sum.toFixed(2);

    }

  });

    $(".price"+target).val(sum);
    console.log("Change successfully");

  });

$("input").keyup(function()
 {
  var target = $(this).parent().attr('class');

  //---------------------get total price---------------------------
  var sum = $(".price"+target).attr('value');

  $('.quantity'+target).each(function()
  {

    var num = $('.quantity'+target).val();

    if(num!=0)
    {
      sum = sum*num;
//--------------------------Round off the price------------------------
      sum  = sum.toFixed(2);

    }

  });

    $(".price"+target).val(sum);
    console.log("Change successfully");

  });


</script>
