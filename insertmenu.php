<!DOCTYPE html>
<title>Insert Menu</title>
<!--PHP-->
<?php
session_start();
include("config.php");
include("userAccess.php");

$editMode = false;

$foodid="";
$foodname="";
$price="";
$foodtype="";

if(isset($_GET['edit'])){
	$editMode = true;
	$foodid=$_GET['edit'];

	$sql = "SELECT foodid,foodname,price,foodtype FROM menu where foodid='$foodid'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {

		while($row = $result->fetch_assoc()) {
		$foodid=$row["foodid"];
		$foodname=$row['foodname'];
		$price=$row["price"];
		$foodtype=$row["foodtype"];

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
<link rel="stylesheet" type="text/css" href="insertmenu.css">
<link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">

<title></title>
</head>
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
<div class="pagecontainer">
  <!--Page title -->
  <div class="pagetitle">
    <h1>Menu - Insert Menu</h1>
		<!--Log Out Button-->
    <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='insertmenu.php?username=logout'">
    <!--Setting-->
    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>
  </div>
  <!--Page contents-->
  <div class="pagecontent">

<!--Form to fill-->
<a href="menu.php" class="returnmenu">Menu</a>

<form name="form1" method="post" action="menu.php" enctype="multipart/form-data" class="formone">
<h2>Menu Details</h2>
	<!--ID-->
	<input name="foodid" class="insertinput" type="text" placeholder="" value="<?php echo $foodid; ?>" style="display: none;">
	<!--Food Name-->
	<strong>Food/Beverage Name:</strong>
	<br>
	<input name="foodname" class="insertinput" type="text" placeholder="Ex: Chicken Chop, Cola Float" value="<?php echo $foodname; ?>" required><br><br>
	<!--Food Price-->
	<strong>Price(RM):</strong>
	<br>
	<input name="price" class="insertinput" type="text" placeholder="2.30, 45.00" value="<?php echo $price; ?>" required><br><br>
	<!--food type SELECT-->
	<strong>Type:</strong>
	<br>
	<select name = "foodtype" class="insertinput">
		<!--Placeholder-->
		<option value="">Select Food Type</option>
		<!--Option 1-->
		<option value= "Food" <?php if ($foodtype=='Food') { echo
			"selected";} ?> > Food </option>
		<!--Option 2-->
		<option value= "Beverage" <?php if ($foodtype=='Beverage') { echo
			"selected";} ?> > Beverage </option>

	</select><br>
	<br><br>
	<?php
	if ($editMode == false){
		echo "<input type='submit' name='submit' value='Submit' class='button1'>";
		echo "<input type='reset' value='Reset' class='button3'>";
	}
	else {
		echo "<input type='submit' name='edit' value='Edit' class='button2'>";
	}
	?>

<!--End of Form-->
</form>


  </div>
</div>

</body>
</html>
