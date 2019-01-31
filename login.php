<?php
session_start();
	if(isset($_SESSION['ezdineUid'])){
      echo '<script type="text/javascript">
      window.location.href = "index.php";
      </script>';
  	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>EzDine</title>
	<!--Icon-->
	<link rel="icon" type="image/gif" href="img/EZDine-logo.png">
	<!--Fonts & CSS-->
	<link rel="stylesheet" type="text/css" href="login.css">
	<link rel="stylesheet" type="text/css" href="ezdine.css">
	<link href="https://fonts.googleapis.com/css?family=Acme" rel="stylesheet">
</head>

<body background="bg.png">
	<!--Form-->
	<div id="formContainer">
		<form class="form" method="POST" action="verification.php">
			<div class="logodiv">
				<img src="img/ezdine_logo.png" class="logo">
			</div><br><br>
			<hr class="hr"><br>
			<div class="login">
				<input type="text" name="username" placeholder="  Username" class="input" required><br><br>
				<input type="password" name="password" placeholder="  Password" class="input" required><br><br>
				<input type="submit" name="sign_in" value="Sign In" class="signin"><br><br>
			</div>
			<hr class="hr">
		</form>
	</div>
</body>
</html>
