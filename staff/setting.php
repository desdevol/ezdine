<?php
session_start();
include("logout.php");
include("config.php");

$userName = $_SESSION['ezdineUid'];
$sql="SELECT type FROM user WHERE username = '$userName'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$type = $row['type'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Setting</title>
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
  <li class="sidenavitem"><a href="index.php">Main Menu</a></li>
  <li class="sidenavitem"><a href="menu.php">Menu</a></li>
</ul>

<!--Contents put here-->
<div class="pagecontainer">
  <!--Page title (can delete if not wanted)-->
  <div class="pagetitle">
    <h1>Setting</h1>
    <!--Log Out Button-->
    <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='setting.php?username=logout'">
    <!--Setting-->
    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>

  </div>
  <!--Page contents-->
  <div class="pagecontent">
    <div class="settingContainer">
      <h2><span style="display: inline-block; width: 25%">Username: &nbsp;</span><span class="settingData"><?php echo $_SESSION["ezdineUid"]; ?></span></h2>
      <h2><span style="display: inline-block; width: 25%">Account Type: &nbsp;</span><span class="settingData"><?php echo $type;?></span></h2>
      <hr>
      <h2>Change Password</h2>
      <form action="settingRedirect.php" method="post">
        <input type="password" name="password" value="" id="pwd" required>
        <label class="check">
          <input type="checkbox" id="showPwd" onclick="showpw()">
          <span class="checkmark"></span>
        </label><br>
        <button type="submit" name="settingPwd" id="settingPwd">Change</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>

<script type="text/javascript">
//-------------------------------Show password----------------------------------
function showpw() {
    var x = document.getElementById("pwd");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>
