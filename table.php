<?php
session_start();
include("logout.php");
include("config.php");
include("userAccess.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>Table Management</title>
<!--Icon-->
<link rel="icon" type="image/gif" href="img/EZDine-logo.png">
<!--Fonts & CSS-->
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="ezdine.css">
<link rel="stylesheet" type="text/css" href="table.css">
<link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">
<!--AJAX-->
<script src="Jquery/jquery.js"></script>
</head>
<body>

<script type="text/javascript">
//Hide Show Div
$(document).ready(function(){
    $("#closeadd").click(function(){
        $("#addDetail").hide();
    });
    $("#addtable").click(function(){
        $("#addDetail").show();
    });
});

//Delete all Javascript
function deleteAll(){
  if ($(".tableblock")[0]) {
    if(confirm("Delete all the tables?")){
      $.ajax({
          data: 'deleteAll',
          url: 'tableredirect.php',
          method: 'POST', // or GET
          success: function() {
              window.location.href='table.php';
          }
      });
    }
    else{
      return false;
    }
  }
  else{
    return false;
  }
}
</script>

<!--Sidenav-->
<ul class="sidenav">
  <li class="sidenavitem"><img src="img/EZDine-logo.png" class="sidenavlogo"></li>
  <li class="sidenavitem"><a href="index.php">Main Menu</a></li>
  <li class="sidenavitem"><a href="menu.php">Menu</a></li>
  <li class="sidenavitem"><a href="payment_history.php">Payment History</a></li>
  <li class="sidenavitem"><a href="table.php" class="active">Table Management</a></li>
  <li class="sidenavitem"><a href="inventory.php">Inventory Management</a></li>
  <li class="sidenavitem"><a href="employee.php">Employee Management</a></li>
  <li class="sidenavitem"><a href="sales.php"> Sales Report</a></li>
</ul>

<!--Contents put here-->
<div class="pagecontainer">
  <!--Page title (can delete if not wanted)-->
  <div class="pagetitle">
    <h1>Table Management</h1>
    <!--Log Out Button-->
    <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='menu.php?username=logout'">
    <!--Setting-->
    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>
  </div>
  <!--Page contents-->
  <div class="pagecontent">

    <!-- The Modal -->
    <div id="myModal" class="modal">
      <!--Edit Table Number Modal -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <form method="post" action="tableredirect.php" id="changeNumForm">
          <label id="changeNumlbl">Change the table number to:</label><br>
          <input type="number" name="tabID" id="tabID" style="display: none;">
          <input type="number" name="changeNum" id="changeNumInput" min="0"><br>
          <button id="changeNumBtn">Save</button>
        </form>
      </div>
    </div>

    <button id="addtable" class="bigbutton" type="button">Add Table</button>
    <button id="deleteall" class="bigbutton" type="button" onclick="deleteAll()">Delete All</button><br>
    <form name="addtableform" method="post" action="tableredirect.php">
      <!--Hide from display-->
      <div id="addDetail">
        <button id="closeadd" type="button">&times</button>
        <input type="number" name="numoftable" id="addinput" placeholder="Set number of tables">
        <button id="setnum" name="setnum">Set</button>
        <button id="addonetable" name="addonetable">Add 1 Table</button>
      </div>
    </form>
    <?php
      //Delete table---------------------------------------------------------
      if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql="DELETE FROM tablemng WHERE tableID='$id'";
        $result = $conn->query($sql);
        //Delete order table and payment table from database
        $sql = "DROP TABLE table".$id."_order";
        $result = $conn->query($sql);
      }

      //Show tables----------------------------------------------------------
      $sql = "SELECT * FROM tablemng";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<div class='tablecontainer'>
            <div class=\"tableblock\">".$row['tableNum']."</div>
            <button class=\"tableFunction\" id=\"editbtn".$row['tableID']."\" onclick=\"openModal(".$row['tableID'].")\">Edit Number</button>
            <button class=\"tableFunction\" onclick=\"window.location.href='table.php?id=".$row['tableID']."'\">Delete</button>
          </div>";
        }
      } else {
        echo "<br>No table added yet, please add tables.";
      }

      $conn->close();
    ?>
  </div>
</div>

</body>
</html>

<script type="text/javascript">
// Get the modal
var modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

function openModal(id){
  modal.style.display = "block";
  document.getElementById("tabID").value = id;
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
</script>
