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

<link rel="stylesheet" type="text/css" href="payment_history.css">
<link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">
</head>
<body>

<!--Sidenav-->
<ul class="sidenav">
  <li class="sidenavitem"><img src="img/EZDine-logo.png" class="sidenavlogo"></li>
  <li class="sidenavitem"><a href="index.php">Main Menu</a></li>
  <li class="sidenavitem"><a href="menu.php">Menu</a></li>
  <li class="sidenavitem"><a href="payment_history.php" class="active">Payment History</a></li>
  <li class="sidenavitem"><a href="table.php">Table Management</a></li>
  <li class="sidenavitem"><a href="inventory.php">Inventory Management</a></li>
  <li class="sidenavitem"><a href="employee.php">Employee Management</a></li>
  <li class="sidenavitem"><a href="sales.php"> Sales Report</a></li>
</ul>

<!--Contents put here-->
<div class="pagecontainer">
  <!--Page title (can delete if not wanted)-->
  <div class="pagetitle">
    <h1>Payment History</h1>
    <!--Log Out Button-->
    <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='payment_history.php?username=logout'">
    <!--Setting-->
    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>

  </div>
  <!--Page contents-->
  <div class="pagecontent">

    <!--Search-->
    <form method="get" action="payment_history.php">
      <input type="text" name="search" id="searchBox" placeholder="Payment ID/Table number/Date" title="Payment ID/Table number/Date">
      <button id="searchBtn">Search</button><br><br>
    </form>


    <?php

    $sql = "SELECT payID, date, time, tableNum from payhistory";
    $result = $conn->query($sql);

    //Search
    if(isset($_GET['search'])){
      if($_GET['search']==""){
        header("Location: payment_history.php");
      }
      else{
        $search=$_GET['search'];
        $sql="SELECT * FROM payhistory WHERE payID LIKE '$search' OR tableNum LIKE '$search' OR date LIKE '%$search%'";
        $result = $conn->query($sql);
      }
    }

      if ($result->num_rows > 0)
      {
        echo '<table><td width="13%">PayID</td><td width="31%">Table Number</td><td width="16%">Date</td><td width="20%">Time</td><td>Action</td></table>';

      while($row = $result->fetch_assoc())
      {
      $payID = $row['payID'];
      echo "<div>
      <input value='".$row["payID"]."' class=\"append1\" name=\"payID\" id='payID' readonly><input value='".$row["tableNum"]."' class=\"append2\" name=\"tableNum\" id='tableNum' readonly><input value='".$row["date"]."' class=\"append3\" name=\"date\" id='date' readonly><input  class=\"append4\" name=\"time\" id='time' value='".$row["time"]."' readonly><input  type=\"submit\" class=\"pdf\" value=\"PDF\" name=\"delete\" onclick=\"window.open('print_receipt.php?pdf=1&payID=".$payID."', '_blank')\"></div>";

      }

     }
     else {
       //No record of payment
       echo "<h2>No record of payment.</h2>";
     }


    ?>



    </div>
</div>


</body>
</html>
