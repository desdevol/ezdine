<?php
session_start();
include("config.php");

//Escape symbols to prevent SQL injection
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "SELECT * FROM user WHERE username = '$username'";
$result = $conn->query($sql);

//If username exist in database
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if (password_verify($password, $row["password"])) {
         $_SESSION['ezdineUid'] = $username;
         $_SESSION['accType'] = $row['type'];

         //Direct to admin's main menu if it's admin
         if($_SESSION['accType'] == 'admin'){
           echo '<script type="text/javascript">
           alert("Login successful.");
           window.location.href = "index.php"
          </script>';
         }
         //Direct to employee main menu if it's employee
         else if($_SESSION['accType'] == 'employee'){
           echo '<script type="text/javascript">
           alert("Login successful.");
           window.location.href = "staff/index.php"
          </script>';
         }
         else if($_SESSION['accType'] == 'chef'){
           echo '<script type="text/javascript">
           alert("Login successful.");
           window.location.href = "chef.php"
          </script>';
         }
    }
    //If password entered is incorrect
    else {
      //Return to login page
      echo '<script type="text/javascript">
      alert("Failed to login, please try again.");
      window.location.href = "login.php"
      </script>';
    }
  }

}
else {
  //Return to login page when username entered does not exist
  echo '<script type="text/javascript">
  alert("No username.");
  window.location.href = "login.php"
  </script>';
}

$conn->close();
?>
