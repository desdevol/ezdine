<?php
  if (isset($_GET['username'])) {
    if ($_GET['username']=="logout") {
        session_destroy();
        echo '<script type="text/javascript">
        alert("Logout successfully.");
        window.location.href = "../login.php"
        </script>';
    }
  }

  if(empty($_SESSION['ezdineUid'])){
      echo '<script type="text/javascript">
      window.location.href = "../login.php";
      </script>';
  }
?>
