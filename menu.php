<?php
session_start();
include("logout.php");
include("config.php");
include("userAccess.php");
?>

<!DOCTYPE html>

<html id="menu">
<head>
<title>Menu</title>

<!--Minor CSS-->
<style type="text/css">
  table, th, td {
    border: 1px solid black;
}
</style>
<!--Icon-->
<link rel="icon" type="image/gif" href="img/EZDine-logo.png">
<!--ez dine css-->
<link rel="stylesheet" type="text/css" href="ezdine.css">

<!--Google Font-->
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

<!--CSS-->
<link rel="stylesheet" type="text/css" href="menu.css">
<link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">


</head>

<!--Body-->
<body>

<!--Sidenav-->
<ul class="sidenav">
  <li class="sidenavitem"><img src="img/EZDine-logo.png" class="sidenavlogo"></li>
  <li class="sidenavitem"><a href="index.php">Main Menu</a></li>
  <li class="sidenavitem"><a href="menu.php" class="active">Menu</a></li>
  <li class="sidenavitem"><a href="payment_history.php">Payment History</a></li>
  <li class="sidenavitem"><a href="table.php">Table Management</a></li>
  <li class="sidenavitem"><a href="inventory.php">Inventory Management</a></li>
  <li class="sidenavitem"><a href="employee.php">Employee Management</a></li>
  <li class="sidenavitem"><a href="sales.php"> Sales Report</a></li>
</ul>

<!--content put in this div-->
<!--Container-->
<div class="pagecontainer">
 <!--Page title-->
 <div class="pagetitle">
    <h1>Menu</h1>
    <!--Log Out Button-->
    <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='menu.php?username=logout'">
    <!--Setting-->
    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>
 </div>

  <!--Page contents-->
    <div class="pagecontent">
    <!--Add Menu Button-->
    <a href="insertmenu.php" class="menubtn">Add Menu</a>
    <form method="get" action="menu.php">
      <input type="text" name="search" id="searchBox" placeholder="Enter food id/food name">
      <button id="searchBtn">Search</button><br><br>
    </form>
<?php
//Insert
$getlastid="SELECT foodid FROM menu ORDER BY foodid DESC LIMIT 1";
      $result2 = $conn->query($getlastid);
      $lastnum = 0;
      if ($result2->num_rows > 0) {
        while($row = $result2->fetch_assoc()) {
         $lastnum = $row['foodid'];
        }
      }

if (isset($_POST['submit'])){
    $lastnum++;
    $foodid=$lastnum;
    $foodname=$_POST['foodname'];
    $price=$_POST['price'];
    $foodtype=$_POST['foodtype'];

    $sql="INSERT into menu values ('$foodid','$foodname','$price','$foodtype')";
    $result = $conn->query($sql);
}

// Edit
if(isset($_POST['edit'])){
$foodid=$_POST['foodid'];
$foodname=$_POST['foodname'];
$price=$_POST['price'];
$foodtype=$_POST['foodtype'];

$sql="UPDATE menu SET foodname='$foodname',price='$price',foodtype='$foodtype' where foodid='$foodid'";
$result = $conn->query($sql);
}

//delete
if(isset($_GET['foodid'])){
    $foodid=$_GET['foodid'];
    $sql="delete from menu where foodid='$foodid'";
    $result = $conn->query($sql);
}

//Select & display
$sql = "SELECT foodid,foodname,price,foodtype FROM menu";
$result = $conn->query($sql);

//Search
if(isset($_GET['search'])){
  if($_GET['search']==""){
    header("Location: menu.php");
  }
  else{
    $search=$_GET['search'];
    $sql="SELECT foodid,foodname,price,foodtype FROM menu WHERE foodid LIKE '%$search%' OR foodname LIKE '%$search%'";
    $result = $conn->query($sql);
  }
}

if ($result->num_rows > 0) {
    echo "<table><tr><th class=\"straightth\">Food ID</th><th class=\"straightth\">Food Name</th><th class=\"straightth\">Price (RM)</th><th class=\"straightth\">Food Type</th><th colspan=\"2\" class=\"straightth\">Functions</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["foodid"]. "</td><td>" . $row["foodname"]. "</td><td>" . $row["price"]."</td>
        <td>" . $row["foodtype"]. "</td>

        <td><a class=\"link\" href='menu.php?foodid=".$row["foodid"]."'>Delete</a>"."</td><td><a class=\"link\" href='insertmenu.php?edit=".$row["foodid"]."'>Edit</a>"."</td></tr> ";
    }
    echo "</table>";
} else {
    echo "No item in menu yet, please add new menu item.";
}

$conn->close();
?>
    </div>

</div>

</body>
</html>
