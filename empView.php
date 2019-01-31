<?php
session_start();
include("logout.php");
include("config.php");
include("userAccess.php");

//Get the staff username
if(isset($_GET['emp'])){
	$staffID = $_GET['emp'];
	$sql = "SELECT *  FROM employee WHERE username = '$staffID'";
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
			$name = $row['name'];
		    $ic = $row['ic'];
		    $email = $row['email'];
		    $hpno = $row['hpno'];
		    $telno = $row['telno'];
		    $gender = $row['gender'];
		    $race = $row['race'];
		    $position = $row['position'];
		    $address = $row['address'];
		    $username = $row['username'];
		}
	}
}

if(empty($_GET['emp'])){
	header("Location: employee.php");
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/gif" href="img/EZDine-logo.png">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="ezdine.css">
  <link rel="stylesheet" type="text/css" href="employee.css">
  <link rel="stylesheet" href="iconpack/iconworks/flaticon.css">
  <script type="text/javascript" src="Jquery/jquery.js"></script>
  <title>Employee Management</title>
</head>

<body>
  <!--Sidenav-->
  <ul class="sidenav">
    <li class="sidenavitem"><img src="img/EZDine-logo.png" class="sidenavlogo"></li>
    <li class="sidenavitem"><a href="index.php">Main Menu</a></li>
    <li class="sidenavitem"><a href="menu.php">Menu</a></li>
    <li class="sidenavitem"><a href="payment_history.php">Payment History</a></li>
    <li class="sidenavitem"><a href="table.php">Table Management</a></li>
    <li class="sidenavitem"><a href="inventory.php">Inventory Management</a></li>
    <li class="sidenavitem"><a href="employee.php" class="active">Employee Management</a></li>
    <li class="sidenavitem"><a href="sales.php"> Sales Report</a></li>
  </ul>

  <!--Contents put here-->
  <div class="pagecontainer">
    <!--Page title (can delete if not wanted)-->
    <div class="pagetitle">
      <h1>Employee Management</h1>
      <!--Log Out Button-->
      <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='employee.php?username=logout'">
			<!--Setting-->
	    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>
		</div>
    <!--Page contents-->
    <div class="pagecontent">
    	<!--Back Button-->
      	<a href="employee.php" type="button" name="backBtn" class="dblueBtn bigBtn" style="margin-bottom: 0;">&#8617; Back</a>

        <!--Form-->
      <div id="newEmpForm">
        <form action="empRedirect.php" method="post" id="empForm">
          <h1 id="formTitle"><i class="flaticon-user-outline"></i> Employee: <?php echo $username ?></h1><br>
          <label>Name</label>
          <p type="text" name="name" class="infoInputView" style="width: 84%;"><?php echo $name ?></p><br>

          <label>I/C</label>
          <p type="tel" name="ic" id="ic" value="<?php echo $ic ?>" class="infoInputView" maxlength="12" style="width: 40%; margin-right: 5%;"><?php echo $ic ?></p>

          <label>Age</label>
          <p id="age" class="infoInputView" style="width: 23%;"></p><br>

          <label>Email</label>
          <p type="email" name="email" class="infoInputView" style="width: 84%;"><?php echo $email ?></p><br>

          <label>HP No.</label>
          <p type="tel" name="hpno" class="infoInputView" maxlength="12" readonly style="width: 30%; margin-right: 8%;"><?php echo $hpno ?></p>

          <label>Tel No.</label>
          <p type="tel" name="telno" class="infoInputView" maxlength="10" readonly style="width: 30%;"><?php echo $telno ?></p><br>

          <label>Gender</label>
          <p class="infoInputView" name="gender" style="width: 35%;" readonly><?php echo $gender ?></p><br>

          <label>Race</label>
          <p name="" class="infoInputView" name="race" style="width: 35%;" readonly><?php echo $race ?></p><br>

          <label>Position</label>
          <p id="position" class="infoInputView" name="position" style="width: 45%; margin-right: 10px;" readonly><?php echo $position ?></p><br>

          <label>Address</label><br>
          <p name="address" rows="5" cols="80" class="infoInputView" value="<?php echo $address ?>" readonly><?php echo $address ?></p><br>
      </div>
    </div>
  </div>
</body>

</html>

<script type="text/javascript" src="Jquery/clock.js"></script>
