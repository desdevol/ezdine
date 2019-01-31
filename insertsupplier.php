<!DOCTYPE html>
<title>Insert Supplier Detail</title>
<!--Icon-->
<link rel="icon" type="image/gif" href="img/EZDine-logo.png">

<?PHP
session_start();
include("config.php");
include("userAccess.php");

$editMode = false;

//Edit
$supplierid="";
$itemname="";
$measurement="";
$price="";
$suppliername="";

if(isset($_GET['edit'])){
	$supplierid=$_GET['edit'];

	$sql = "SELECT * FROM supplier where supplierid='$supplierid'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {

		while($row = $result->fetch_assoc()) {
		$supplierid=$row["supplierid"];
		$itemname=$row['itemname'];
		$measurement=$row["measurement"];
		$price=$row["price"];
		$suppliername=$row["suppliername"];

		$editMode = true;
		}
	}
}
?>

<!--HTML-->
<html>
<head>
<!--Style-->
<style type="text/css">
	table, th, td{
		border: 1px solid black;
	}

</style>
<!--CSS Links-->
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="ezdine.css">
<link rel="stylesheet" type="text/css" href="insertsupplier.css">
<link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">

<title></title>
</head>
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
<div class="pagecontainer">
  <!--Page title -->
  <div class="pagetitle">
    <h1>Supplier Details</h1>
		<!--Log Out Button-->
    <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='insertsupplier.php?username=logout'">
		<!--Setting-->
    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>
	</div>
  <!--Page contents-->
  <div class="pagecontent">

<!--Form to fill-->
<a href="purchaseorder.php" class="returnmenu">Back</a>

<form name="form1" method="post" action="inventoryRedirect.php" class="formone">
<h2>Supplier Details</h2>
	<!--ID-->
	<input name="supplierid" class="insertinput" type="text" placeholder="" value="<?php echo $supplierid; ?>" style="display: none;">

	<!--Item Name-->
	<strong>Item Name:</strong>
	<br>
	<input name="itemname" class="insertinput" type="text" placeholder="Ex:Pepper" value="<?php echo $itemname; ?>" required><br><br>


	<!--Measurement-->
	<strong>Measurement</strong>
	<br>
	<input name="measurement" class="insertinput" type="text" placeholder="Ex: 250ml" value="<?php echo $measurement; ?>" required><br><br>

	<!--Price-->
	<strong>Price</strong>
	<br>
	<input name="price" class="insertinput" type="text" placeholder="Ex: 25.50" value="<?php echo $price; ?>" required><br><br>

	<!--Supplier-->
	<strong>Supplier</strong>
	<br>
	<input name="suppliername" class="insertinput" type="text" placeholder="Ex: Justin Trading" value="<?php echo
	$suppliername; ?>" required><br><br>

	<br>
	<?php
		//If is editing
		if($editMode){
			echo "<input type='submit' name='edit' value='Edit' class='button1'>";
		}
		//If not edit, just add new supplier
		else {
			echo "<input type='text' name='supplierid' value='".$supplierid."' hidden>";
			echo "<input type='submit' name='submit' value='Submit' class='button1'>";
		}
	?>
<!--End of Form-->
</form>


  </div>
</div>

</body>
</html>
