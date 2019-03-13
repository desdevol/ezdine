<?php
session_start();
include("logout.php");
include("config.php");
include("userAccess.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>EzDine</title>
<link rel="icon" type="image/gif" href="img/EZDine-logo.png">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="ezdine.css">

<link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">
<link rel="stylesheet" type="text/css" href="payment.css">
</head>
<body>

<!--Sidenav-->
<ul class="sidenav">
  <li class="sidenavitem"><img src="img/EZDine-logo.png" class="sidenavlogo"></li>
  <li class="sidenavitem"><a href="index.php" class="active">Main Menu</a></li>
  <li class="sidenavitem"><a href="menu.php">Menu</a></li>
  <li class="sidenavitem"><a href="payment_history.php">Payment History</a></li>
  <li class="sidenavitem"><a href="table.php">Table Management</a></li>
  <li class="sidenavitem"><a href="inventory.php">Inventory Management</a></li>
  <li class="sidenavitem"><a href="employee.php">Employee Management</a></li>
  <li class="sidenavitem"><a href="sales.php"> Sales Report</a></li>
</ul>

<!--Contents put here-->
<div class="pagecontainer">
  <!--Page title (can delete if not wanted)-->
  <div class="pagetitle">
    <h1>Preview Receipt (TableID=<?php echo $_GET['tableID']?>)</h1>
    <!--Log Out Button-->
    <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='index.php?username=logout'">
    <!--Setting-->
    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>

  </div>
  <!--Page contents-->
  <div class="pagecontent">

<div class="payment">

<table><td width="13%">Foodid</td><td width="31%">FoodName</td><td width="20%">Quantity</td><td width="16%">Price(RM)</td></table>
<form action="insertOrder.php" method="post">
<!-----------------------------Select and display order into preview receipt------------------------------>

<?php


   if(isset($_GET['tableID']))
   {
      $tableID = $_GET['tableID'];
      echo "<input id='gettableID' value='".$tableID."' name='tableID' hidden>";
   }

    $sql = "SELECT a.foodid,a.foodname,SUM(a.price) AS stackedPrice,SUM(a.quantity) AS stackedQty FROM table".$tableID."_order AS a GROUP BY a.foodid";
    $results = $conn->query($sql);

    if ($results->num_rows > 0)
    {
      $totalprice = 0;
      while($row = $results->fetch_assoc())
      {
        $totalprice += $row['stackedPrice'];

      echo "<div class=\"".$row["foodid"]."\" id='".$row["foodid"]."'>
      <input value='".$row["foodid"]."' class=\"append1 foodid1\" name=\"foodid\" id='foodid' readonly><input value='".$row["foodname"]."' class=\"append2 foodname1\" name=\"foodname\" id='foodname' readonly><input  class=\"append4 quantity1".$row["foodid"]."\" name=\"quantity\" id='quantity' value='".$row["stackedQty"]."' readonly><input value='".$row["stackedPrice"]."' class=\"append3 price1".$row["foodid"]."\" name=\"price\" id='price' readonly></div>";

      }

    }
    else{
    	header("Location: index.php");
    }

     $roundedprice = round($totalprice, 1);
     echo "<br><br><input value='Total Price:' class=\"totalprice\"  readonly><input value='".$roundedprice."' class=\"total\" name=\"totalprice\"  readonly>";

?>  

  
        <!----------Insert pay amount------------->
        <div class="totalPayment">
        <input value="Pay Amount:" class="payAmount" readonly>
        <input name="payAmount" class="payAmount1">
        </div>
      
        <!---------Complete payment button---------->
        <div>
           <input class="paybtn" value="Pay" type="submit" name="completePayment" >
        </div>

</form>

      </div>
    </div>

    </div>
</div>


</body>
</html>