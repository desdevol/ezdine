<!------------Dropdown selection to retrive foodtype----------------->
<?php
session_start();
$connect = new PDO("mysql:host=localhost;dbname=ezdine", "root", "");
$query = "SELECT DISTINCT foodtype FROM menu";

$statement = $connect->prepare($query);
$statement->execute();
$result123=$statement->fetchAll();
?>



<?php

include("logout.php");
include("config.php");
include("userAccess.php");
?>
<!--Icon-->
<link rel="icon" type="image/gif" href="img/EZDine-logo.png">

<!DOCTYPE html>
<html>
<head>
<!--popup-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Order</title>
 <link rel="stylesheet" type="text/css" href="order_page.css">
 <link rel="stylesheet" type="text/css" href="insertOrder.css">
   <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="ezdine.css">
  <link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">
<script type="text/javascript" src="Jquery/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>

<!-- Log out function-->

<!-------------------side nav------------------------->
<ul class="sidenav">
  <li class="sidenavitem"><img src="img/EZDine-logo.png" class="sidenavlogo"></li>
  <li class="sidenavitem"><a href="index.php" >Main Menu</a></li>
  <li class="sidenavitem"><a href="menu.php" >Menu</a></li>
  <li class="sidenavitem"><a href="payment_history.php">Payment History</a></li>
  <li class="sidenavitem"><a href="table.php" >Table Management</a></li>
  <li class="sidenavitem"><a href="inventory.php">Inventory Management</a></li>
  <li class="sidenavitem"><a href="employee.php">Employee Management</a></li>
  <li class="sidenavitem"><a href="sales.php"> Sales Report</a></li>
</ul>

<!-- ----------------The Modal ---------------------->
<body>

<!----------------Contents put here------------------>
<div class="pagecontainer">
<!-------Page title (can delete if not wanted)------->
<div class="pagetitle">
<h1>Order</h1>
<!-------------------Log Out Button------------------>
<input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='order_page.php?username=logout'">
<!--Setting-->
<a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>
</div>
  <!-----------------Page contents-------------------->

<div class="pagecontent">

<div id="myModal" class="modal">

<!------------------ Modal content ------------------>
<div class="modal-content">
<div class="modal-header">

</div>



</div>
</div>

<!----------------------Order list-------------------->

    <div class="orderlist" >
    <h1>&nbspOrder List</h1>
    <hr>
    <table><td width="13%">Foodid</td><td width="31%">FoodName</td><td width="16%">Price(RM)</td><td width="20%">Quantity</td><td>Action</td></table>
    <form id="orderdetail" method="post" action="insertOrder.php">

    <div class="order_detail" id="order_detail">


    <?php
    $hasOrder = 0;
//-------------Get tableID-----------//

    if(isset($_GET['tableID']))
          {
            $tableID = $_GET['tableID'];
            echo "<input id='getTableID' value='".$tableID."' name='tableID' hidden>";
          }

//------------------------------Display Order Detail from DB----------------------------------//

    $sql = "SELECT a.foodid,a.foodname,SUM(a.price) AS stackedPrice,SUM(a.quantity) AS stackedQty FROM table".$tableID."_order AS a GROUP BY a.foodid";
    $results = $conn->query($sql);

    if ($results->num_rows > 0)
    {
      $hasOrder = 1;
      while($row = $results->fetch_assoc())
      {

      echo "<div class=\"".$row["foodid"]."\" id='".$row["foodid"]."'>
      <input value='".$row["foodid"]."' class=\"append1 foodid1\" name=\"foodid\" id='foodid' readonly><input value='".$row["foodname"]."' class=\"append2 foodname1\" name=\"foodname\" id='foodname' readonly><input value='".$row["stackedPrice"]."' class=\"append3 price1".$row["foodid"]."\" name=\"price\" id='price' readonly><input  class=\"append4 quantity1".$row["foodid"]."\" name=\"quantity\" id='quantity' value='".$row["stackedQty"]."' readonly><button value='".$row["foodid"]."' type=\"submit\" class=\"delete\" name=\"delete\">Delete</button></div>";

      }

     }

    ?>
</div>
    <!---------------------------------Send btn--------------------------------->
      <?php
        if(isset($_GET['tableID']))
          {
            $tableID = $_GET['tableID'];
            echo "<input id='getTableID' value='".$tableID."' name='tableID' hidden>";
          }
      ?>

        <div>
          <input class="sendbtn" value="Send" name="sendOrder" type="submit" >
        </div>

    <!---------------------------------Payment btn--------------------------------->
        <?php
          if($hasOrder == 1){
            echo '
            <div>
              <input class="paybtn" value="Pay" type="submit" name="pay" >
            </div>';
          }
        ?>

      </div>
    </form>

</div>
</div>



<!----------------------------- Menu ---------------------------------->
<div class="menu">
<h1>&nbspMenu</h1>



<!-------------------------Select Category----------------------------->
<div class="styled-select blue semi-square">
<select name="multi_search_filter" id="multi_search_filter" >
  <option value="">Food Type</option>
  <?php
  foreach ($result123 as $row)
  {
    echo '<option value"'.$row["foodtype"].'" >'.$row["foodtype"].'</option>';
  }
  ?>

</select>
<input type="hidden" name="hidden_input" id="hidden_input">
</div>
<hr>

<br>

<div id="foodbutton">
</div>
</div>




</div>
</div>

</body>







<!-----------------------Search Category----------------------------->
<script>
$(document).ready(function(){

 load_data();
console.log("Search done");

 function load_data(query='')
 {
  $.ajax({
   url:"searchFood.php",
   method:"POST",
   data:{query:query},
   success:function(data)
   {
    $('#foodbutton').html(data);
   }
  })
 }

 $('#multi_search_filter').change(function(){
  $('#hidden_input').val($('#multi_search_filter').val());
  var query = $('#hidden_input').val();
  load_data(query);
  console.log("Search done");

 });

});

</script>





</html>
