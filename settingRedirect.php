<?php
session_start();
include("config.php");
if (isset($_POST['settingPwd'])) {
  $password = $_POST['password'];
  $hash = password_hash($password, PASSWORD_BCRYPT);
  $username = $_SESSION['ezdineUid'];

  $sql = "UPDATE user SET password = '$hash' WHERE username = '$username'";
  $result = $conn->query($sql);
  echo "<script>
  alert('Password changed successfully.');
  window.location.href='index.php';
  </script>";
}
?>
