<?php
$userName = $_SESSION['ezdineUid'];
$sql="SELECT type FROM user WHERE username = '$userName'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$type = $row['type'];

if ($type == 'chef') {
  header("Location: chef.php");
}

if($type == 'employee') {
  header("Location: staff/index.php");
}
?>
