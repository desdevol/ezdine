<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="ezdine_login_page.css">
	<link href="https://fonts.googleapis.com/css?family=Acme" rel="stylesheet"> 
</head>

<body background="bg.png">
<form class="form" method="POST" action="verification.php" >
<div class="logo1">
<img src="img/ezdine_logo.png" class="logo">
</div>
<div class="login">

<br>
<br>
<hr class="hr">
<br>
<br>
<input type="text" name="username" placeholder="  Username" class="input" required>
<br>
<br>
<input type="password" name="password" placeholder="  Password" class="input" required>
<br>
<br> 
<input type="submit" name="sign_in" value="Sign in" class="signin">

<br>
<br>
<hr class="hr">
</form>
</div>
</body>
</html>