<?php
session_start();
include("logout.php");
include("config.php");
include("userAccess.php");

//Get the edit
if (isset($_GET['editEmp'])) {
  $id = $_GET['editEmp'];
  $sql = "SELECT * FROM employee WHERE ID = '$id'";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
      $id = $row['ID'];
      $name = $row['name'];
      $ic = $row['ic'];
      $email = $row['email'];
      $hpno = $row['hpno'];
      $telno = $row['telno'];
      $gender = $row['gender'];
      $race = $row['race'];
      $pos = $row['position'];
      $address = $row['address'];
      $username = $row['username'];
    }

  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" type="image/gif" href="img/EZDine-logo.png">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

  <!--CSS-->
  <link rel="stylesheet" type="text/css" href="ezdine.css">
  <link rel="stylesheet" type="text/css" href="employee.css">
  <link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">

  <!--Scripts-->
  <script type="text/javascript" src="Jquery/jquery.js"></script>
  <script type="text/javascript" src="Jquery/jquery.are-you-sure.js"></script>
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
      <!--Modal-->
      <div id="myModal" class="modal">
        <!--Insert Job Position Modal -->
        <div class="modal-content">
          <span class="close">&times;</span>
            <label class="Joblbl">Add new job position:</label><br>
            <input type="text" name="jobPosition" id="positionInput" class="positionInput" maxlength="30" required autocomplete="off">&nbsp;
            <button id="addPosBtn" name="addPos" class="redBtn bigBtn" disabled>+</button>
            <div id="availability"></div>
        </div>
      </div>

      <!--Back Button-->
      <a href="employee.php" type="button" name="backBtn" class="dblueBtn bigBtn" style="margin-bottom: 0;">&#8617; Back</a>
      <!--Form-->
      <div id="newEmpForm">
        <form action="empRedirect.php" method="post" id="empForm">
          <h1 id="formTitle">Edit Employee Information</h1><br>

          <label style="width: 20%;">User ID</label>
          <input type="text" name="username" value="<?php echo $username ?>" id="userid" class="infoInput" readonly style="width: 50%;"><br>
          <label>Name</label>
          <input type="text" name="name" value="<?php echo $name; ?>" class="infoInput" required style="width: 84%;" placeholder="John Doe"><br>
          <label>I/C</label>
          <input type="tel" name="ic" value="<?php echo $ic; ?>" class="infoInput" maxlength="12" required style="width: 84%;" placeholder="990102016969"><br>
          <label>Email</label>
          <input type="email" name="email" value="<?php echo $email; ?>" class="infoInput" required style="width: 84%;" placeholder="ezdine@gmail.com"><br>
          <label>HP No.</label>
          <input type="tel" name="hpno" value="<?php echo $hpno; ?>" class="infoInput" maxlength="12" required style="width: 30%; margin-right: 8%;" placeholder="012-3456789">
          <label>Tel No.</label>
          <input type="tel" name="telno" value="<?php echo $telno; ?>" class="infoInput" maxlength="10" required style="width: 30%;" placeholder="07-3335566"><br>

          <label>Gender</label>
          <select class="infoInput" name="gender" style="width: 35%;" required>
            <option value="" hidden selected>Select a gender</option>
            <option value="Male" <?php if($gender == "Male"){echo "selected";}?>>Male</option>
            <option value="Female" <?php if($gender == "Female"){echo "selected";}?>>Female</option>
          </select><br>

          <label>Race</label>
          <select class="infoInput" name="race" style="width: 35%;" required>
            <option value="" hidden selected>Select a race</option>
            <option value="Chinese" <?php if($race == "Chinese"){echo "selected";}?> >Chinese</option>
            <option value="Malay" <?php if($race == "Malay"){echo "selected";}?> >Malay</option>
            <option value="Indian" <?php if($race == "Indian"){echo "selected";}?> >Indian</option>
            <option value="Others" <?php if($race == "Others"){echo "selected";}?> >Others</option>
          </select><br>

          <label>Position</label>
          <select id="position" class="infoInput" name="position" style="width: 45%; margin-right: 10px;" required>
            <option value="" selected>Select employee position</option>
            <?php
              $sql = "SELECT * FROM emp_position";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "
                  <option value='".$row['position']."' ".(($pos== $row['position'])?'selected="selected"':"")." >"
                  .$row['position'].
                  "</option>";
                }
              }
            ?>
          </select>
          <!--Triggers modal button-->
          <button type="button" name="addPosition" class="redBtn smallBtn" id="addBtn" onclick="openModal()">+</button><br>

          <br><label>Address</label><br>
          <textarea name="address" value="<?php echo $address ?>" rows="5" cols="80" class="infoInput"><?php echo $address ?></textarea><br>

          <button type="submit" name="editEmp" class="bigBtn redBtn" style="margin: 10% 0 0 0; padding: 2% 5%;">Save</button>
        </form>
      </div>
    </div>
  </div>
</body>

<script type="text/javascript">

//---------------------------Detect unsaved info--------------------------------
$(function() {
    $('#empForm').areYouSure(
      {
        message: 'It looks like you have been editing something. '
               + 'If you leave before saving, your changes will be lost.'
      }
    );
});

//-----------------------------Get the modal------------------------------------
var modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

function openModal(){
  modal.style.display = "block";
  $("#positionInput").focus();
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

//------------------------AJAX to add new position------------------------------
$("#addPosBtn").click( function() {
  var jobPos= $("#positionInput").val();

  $.ajax({
    method: 'POST',
    url: 'empRedirect.php',
    data: {addPos: jobPos},
    success: function(err){
      alert("Job position is added.");
      $("#position").append("<option value='" + jobPos+"'>" + jobPos+"</option>");
      $("#myModal").hide();
      console.log(err);
    },
    error: function(err){
      alert("Failed to insert data, something went wrong.");
      console.log(err);
    }
  });
});

//----------------------Check job position availability-------------------------
$(document).ready(function(){
  $("#positionInput").on('keyup', function(){
    var checkposition = $(this).val();
    $.ajax({
      url: 'empRedirect.php',
      method: 'POST',
      data: {check_position: checkposition},
      success:function(data){
        if(data != '0'){
          $('#availability').html('<span style="color:#ff3030">&times; Job position already existed.</span>');
          $('#addPosBtn').attr("disabled", true);
          console.log(data);
        }
        else{
         $('#availability').html('<span style="color:#5bff5b">&#10004 Job position input is available.</span>');
         $('#addPosBtn').attr("disabled", false);
         console.log(data);
        }

      }
    });
  });
});
</script>
</html>
