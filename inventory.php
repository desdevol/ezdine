<?php
session_start();
include("logout.php");
include("config.php");
include("userAccess.php");
?>

<!DOCTYPE html>

<html id="inventory">
<head>
<title>Inventory</title>

<!--Minor CSS-->
<style type="text/css">
  table, th, td {
    border: 1px solid black;
}
</style>
<!--Icon-->
<link rel="icon" type="image/gif" href="img/EZDine-logo.png">
<link rel="stylesheet" href="iconpack/iconworks/flaticon.css">

<!--ez dine css-->
<link rel="stylesheet" type="text/css" href="ezdine.css">

<!--Google Font-->
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

<!--Menu CSS-->
<link rel="stylesheet" type="text/css" href="supplier.css">


</head>

<!--Body-->
<body>

<!--Sidenav-->
<ul class="sidenav">
  <li class="sidenavitem"><img src="img/EZDine-logo.png" class="sidenavlogo"></li>
  <li class="sidenavitem"><a href="index.php">Main Menu</a></li>
  <li class="sidenavitem"><a href="menu.php">Menu</a></li>
  <li class="sidenavitem"><a href="payment_history.php">Payment History</a></li>
  <li class="sidenavitem"><a href="table.php">Table Management</a></li>
  <li class="sidenavitem"><a href="inventory.php" class="active">Inventory Management</a></li>
  <li class="sidenavitem"><a href="employee.php">Employee Management</a></li>
  <li class="sidenavitem"><a href="sales.php"> Sales Report</a></li>
</ul>

<!--content put in this div-->
<!--Container-->
<div class="pagecontainer">
 <!--Page title-->
 <div class="pagetitle">
    <h1>Inventory</h1>
    <!--Log Out Button-->
    <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='inventory.php?username=logout'">
    <!--Setting-->
    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>
 </div>

  <!--Page contents-->
    <div class="pagecontent">
    <!--Add Button-->
    <a href="purchaseorder.php" class="menubtn" style="font-size: 20px;"><i class="flaticon-shopping-cart"></i> Add Purchase Order</a>
    <form method="get" action="inventory.php">
      <input type="text" name="search" id="searchBox" placeholder="Enter item name/Supplier Name">
      <button id="searchBtn">Search</button><br><br>
    </form>

<?php
//Delete inventory item
if(isset($_GET['invDel'])){
    $supplierid=$_GET['invDel'];
    $sql="DELETE from inventory where supplierid='$supplierid'";
    $result = $conn->query($sql);
}

//Select & display
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);

//Search
if(isset($_GET['search'])){
  if($_GET['search']==""){
    header("Location: inventory.php");
  }
  else{
    $search=$_GET['search'];
    $sql="SELECT * FROM inventory WHERE suppliername LIKE '%$search%' OR itemname LIKE '%$search%'";
    $result = $conn->query($sql);
  }
}

if ($result->num_rows > 0) {
    echo "<table><tr>
    <th class=\"straightth\">ID</th>
    <th class=\"straightth\">Supplier ID</th>
    <th class=\"straightth\">Item</th>
    <th class=\"straightth\">Measurement</th>
    <th class=\"straightth\">Price per Unit</th>
    <th class=\"straightth\">Supplier</th>
    <th class=\"straightth\">Quantity</th>
    <th class=\"straightth\">Total Price</th>
    <th class=\"straightth\">Functions</th>
    </tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row["invID"]. "</td>
        <td>" . 'SUP'.str_pad($row["supplierid"],4,"0",STR_PAD_LEFT). "</td>
        <td>" . $row["itemname"]. "</td>
        <td>" . $row["measurement"]."</td>
        <td>" . $row["price"]."</td>
        <td>" . $row["suppliername"]."</td>
        <td>" . $row["quantity"]."</td>
        <td>" . $row["totalprice"]."</td>


        <td style='text-align: center'><a class=\"link\" href='inventory.php?invDel=".$row["supplierid"]."'>Delete</a>"."</td>
        </tr> ";
    }
    echo "</table>";
} else {
    echo "No purchase order.";
}

$conn->close();
?>
    </div>

</div>

</body>
</html>
