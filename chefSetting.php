<?php
    session_start();
    include("config.php");
    include("logout.php");

    $userName = $_SESSION['ezdineUid'];
    $sql="SELECT type FROM user WHERE username = '$userName'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $type = $row['type'];

    //If not a chef account visits this page
    if($type != 'chef'){
      if($type == 'employee'){
        header("Location: staff/index.php");
      }
      else if ($type == 'admin') {
        header("Location: index.php");
      }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Setting</title>
    <!--CSS-->
    <link rel="stylesheet" href="chef.css">
    <link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">
    <!--Logo and Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="icon" type="image/gif" href="img/EZDine-logo.png">
    <!--Scripts-->
    <script type="text/javascript" src="Jquery/jquery.js"></script>
  </head>
  <body>
    <div class="pagetitle">
      <h1>Chef Order Display</h1>
      <!--Logout-->
      <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='chefSetting.php?username=logout'">
      <!--Setting-->
      <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>
    </div>
    <a href="chef.php" id="backBtn">Back</a>
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
