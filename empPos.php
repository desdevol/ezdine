<?php
session_start();
include("logout.php");
include("config.php");
include("userAccess.php");

//Delete job position
if (isset($_POST['deletePos'])) {
  $id = $_POST['posID'];
  $sql = "DELETE FROM emp_position WHERE ID = '$id'";
  $result = $conn->query($sql);
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
      <!--Modal-->
      <div id="addPosModal" class="modal">
        <!--Insert Job Position Modal -->
        <div class="modal-content">
          <span class="close">&times;</span>
            <label class="Joblbl">Add new job position:</label><br>
          <form method="post" action="empPosRedirect.php">
            <input type="text" name="jobPosition" id="positionInput" class="positionInput" maxlength="30" required autocomplete="off"><br>
            <div id="availability"></div>
          </form>
        </div>
      </div>

      <!--Modal2 (Edit)-->
      <div id="editPosModal" class="modal">
        <!--Edit Job Position Modal -->
        <div class="modal-content">
          <span class="close">&times;</span>
            <label class="Joblbl">Edit job position:</label><br>
          <form method="post" action="empPosRedirect.php">
            <input type="text" name="jobPosition" id="editPosInput" class="positionInput" maxlength="30" required autocomplete="off"><br>
            <div id="existance" style="margin-left:4%"></div>
            <input id='posEditID' name="posEditID" hidden></input>
          </form>
        </div>
      </div>

      <!--Back Button-->
      <a href="employee.php" type="button" name="backBtn" class="dblueBtn bigBtn" style="margin-bottom: 0;">&#8617; Back</a>
      <button type="button" name="button" class="redBtn bigBtn" onclick="modalAdd()">+</button>

      <?php
        $sql = "SELECT * FROM emp_position";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          echo "<table class='empTable' style='width: 50%;'><tr><th>ID</th><th>Position</th><th colspan='2'>Action</th>";
          while($row = $result->fetch_assoc()) {
            echo "
              <tr><td>".$row['ID']."</td><td>".$row['position']."</td>
              <td class='center'><button class='redBtn empPosBtn' onclick='deletePos(".$row['ID'].")'><i class='flaticon-rubbish-bin'></i></button></td>
              <td class='center'><button class='redBtn empPosBtn' onclick='editPos(".$row['ID'].")'><i class='flaticon-pencil-outline'></i></button></td>
            ";
          }
          echo "</table>";
        } else {
          echo "<br>
          <i class='flaticon-add-document' style='margin-left: 40%;'></i><br>
          <p style='font-size: 30px; text-align: center;'>No job position is added yet, please add new job position.</p>";
        }

        $conn->close();
      ?>
    </div>
  </div>
</body>

<script type="text/javascript">
//---------------------------AJAX delete position-------------------------------
  function deletePos(id){
    $.ajax({
      method: 'POST',
      url: 'empPos.php',
      data: {deletePos: 'deletePos', posID: id},
      success: function(err){
        alert("Job position is deleted.");
        console.log(err);
        location.reload();
      },
      error: function(err){
        alert("Failed to perform this action, something went wrong.");
        console.log(err);
      }
    });
  }
//------------------------------Edit position-----------------------------------
function editPos(id){
  $("#editPosModal").show();
  $("#posEditID").val(id);
}

//----------------------------------Modal---------------------------------------
  function modalAdd(){
    $("#addPosModal").show();
    $("#positionInput").focus();
  }

  //Get Modal
  var modal = document.getElementById('addPosModal');

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
//------------------------------Modal 2(Edit)-----------------------------------
//Get Modal
var modal2 = document.getElementById('editPosModal');

// Get the <span> element that closes the modal
var span2 = document.getElementsByClassName("close")[1];

// When the user clicks on <span> (x), close the modal
span2.onclick = function() {
    modal2.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
}
//-------------------Check job position availability----------------------
$(document).ready(function(){
  $("#positionInput").on('keyup', function(){
    var checkposition = $(this).val();
    $.ajax({
      url: 'empPosRedirect.php',
      method: 'POST',
      data: {check_position: checkposition},
      success:function(html){
        $('#availability').html(html);
      }
    });
  });

  //For edit
  $("#editPosInput").on('keyup', function(){
    var checkposition = $(this).val();
    $.ajax({
      url: 'empPosRedirect.php',
      method: 'POST',
      data: {check_position: checkposition},
      success:function(html){
        $('#existance').html(html);
      }
    });
  });
});
</script>

</html>
