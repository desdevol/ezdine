<?php
session_start();
include("logout.php");
include("config.php");

$userName = $_SESSION['ezdineUid'];
$sql="SELECT type FROM user WHERE username = '$userName'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$type = $row['type'];

if ($type == 'chef') {
  header("Location: chef.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>EzDine</title>
<link rel="icon" type="image/gif" href="../img/EZDine-logo.png">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="ezdine.css">
<link rel="stylesheet" type="text/css" href="index.css">
<link rel="stylesheet" type="text/css" href="../iconpack/iconworks/flaticon.css">
</head>
<body>

<!--Sidenav-->
<ul class="sidenav">
  <li class="sidenavitem"><img src="../img/EZDine-logo.png" class="sidenavlogo"></li>
  <li class="sidenavitem"><a href="index.php" class="active">Main Menu</a></li>
  <li class="sidenavitem"><a href="menu.php">Menu</a></li>
</ul>

<!--Contents put here-->
<div class="pagecontainer">
  <!--Page title (can delete if not wanted)-->
  <div class="pagetitle">
    <h1>Main Menu</h1>
    <!--Log Out Button-->
    <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='index.php?username=logout'">
    <!--Setting-->
    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>

  </div>
  <!--Page contents-->
  <div class="pagecontent">
  <?php
    //Show tables----------------------------------------------------------
    $sql = "SELECT * FROM tablemng";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
     while($row = $result->fetch_assoc()) {
        //If table has order
        if ($row['status'] == 0) {
          echo
          "<div class=\"tablecontainer\" onclick=\"window.location.href='order_page.php?tableID=".$row['tableID']."'\">

          <div class=\"tableblock empty\" value='".$row["tableID"]."'>".$row['tableNum']."</div>

          </div>";
        }
        //If table has no order
        elseif ($row['status'] == 1) {
          echo
          "<div class=\"tablecontainer orderedContainer\" onclick=\"window.location.href='order_page.php?tableID=".$row['tableID']."'\">

          <div class=\"tableblock ordered\" value='".$row["tableID"]."'>".$row['tableNum']."</div>

          </div>";
        }

      }
    } else {
      echo "<br><p id=\"noTables\">No table added yet, please add tables at the <a href='table.php'>table page.</a></p>";
    }

    $conn->close();
    ?>
  </div>
</div>


</body>
</html>
