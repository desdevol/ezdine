<?php
session_start();
include("logout.php");
include("config.php");
include("userAccess.php");
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
      <!--Modal-->
      <div id="editPassModal" class="modal">
        <!--Insert Job Position Modal -->
        <div class="modal-content">
          <span class="close">&times;</span>
          <form method="post" action="empRedirect.php">
            <label class="Joblbl"><i class="flaticon-locked-padlock"></i>&nbsp;Enter new password:</label><br>
            <input type="text" name="pwid" id="pwid" hidden>
            <input type="password" id="password" name="password" class="infoInput" style="width: 50%; margin-left: 4%;" required>&nbsp;
            <label class="check">Show
              <input type="checkbox" id="showpwcheck" onclick="showpw()">
              <span class="checkmark"></span>
            </label><br>
            <button id="editPwBtn" name="editPw" class="redBtn bigBtn" style="margin-left: 4%;">Confirm</button>
          </form>
        </div>
      </div>

      <a href="newEmp.php" type="button" name="addEmp" class="bigBtn dblueBtn">Add New Employee</a>
      <a href="empPos.php" type="button" name="attendance" class="bigBtn dblueBtn">Manage Job Position</a>

      <!--Seach Bar-->
      <form method="get" action="employee.php">
        <input type="text" name="search" id="searchBox" placeholder="Enter employee id/name/position">
        <button id="searchBtn" class="redBtn smallBtn"><i class="flaticon-magnifying-glass"></i></button><br>
      </form>

      <?php
        //Display
        $sql = "SELECT username, name, position, ID FROM employee";
        $result = $conn->query($sql);

        //Search
        if(isset($_GET['search'])){
          if($_GET['search']==""){
            header("Location: employee.php");
          }
          else{
            $search=$_GET['search'];
            $sql="SELECT username, name, position, ID FROM employee WHERE username LIKE '%$search%' OR name LIKE '%$search%' OR position LIKE '%$search%'";
            $result = $conn->query($sql);
          }
        }
        if ($result->num_rows > 0) {
          echo "<table class='empTable'><tr><th>ID</th><th>Name</th><th>Position</th><th colspan='3'>Action</th>";
          while($row = $result->fetch_assoc()) {
            echo "
              <tr><td style='text-align: center'><a class='empUsername' href='empView.php?emp=".$row['username']."'>".$row['username']."</a></td><td>".$row['name']."</td><td>".$row['position']."</td>
              <td class='center'><button class='redBtn empPosBtn' onclick='delEmp(".$row['ID'].")'><i class='flaticon-rubbish-bin'></i></button></td>

              <form method='get' action='editEmp.php'>
              <td class='center'><button class='redBtn empPosBtn' name='editEmp' value='".$row['ID']."'><i class='flaticon-pencil-outline'></i></button></td>
              </form>

              <td class='center'><button class='redBtn empPosBtn' name='editPw' onclick='editPw(".$row['ID'].")'><i class='flaticon-locked-padlock'></i></button></td>
            ";
          }
          echo "</table>";
        } else {
          echo "<br>
          <i class='flaticon-add-document' style='margin-left: 40%;'></i><br>
          <p style='font-size: 30px; text-align: center;'>No employee is added yet, please add new employee.</p>";
        }

        $conn->close();
      ?>
    </div>
  </div>
</body>

<script type="text/javascript">
  //-------------------------------Show password----------------------------------
  function showpw() {
      var x = document.getElementById("password");
      if (x.type === "password") {
          x.type = "text";
      } else {
          x.type = "password";
      }
  }

  //---------------Delete Employee-------------------
  function delEmp(id){
    if (confirm("Delete this employee?")) {
      $.ajax({
          data: {delEmp: id},
          url: 'empRedirect.php',
          method: 'POST', // or GET
          success: function() {
              alert("Account has been deleted");
              window.location.href='employee.php';
              console.log("Success");
          },
          failed: function() {
              console.log("Failed");
          }
      });
    }
  }

  //------------------Edit Password---------------------
  function editPw(id){
    $("#editPassModal").show();
    $("#password").focus();
    $("#pwid").val(id);
  }

  //---------------------Modal--------------------------
  var modal = document.getElementById('editPassModal');

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

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
</script>
</html>
