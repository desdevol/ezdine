 <!DOCTYPE html>
<html>
<head>
    <title>Login_database</title>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ezdine";

// Create connection
$conn=new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];

    $sql="insert into user values ('$username','$password','$firstname','$lastname')";

    $result = $conn->query($sql);
}

if(isset($_GET['username'])){
    $username=$_GET['username'];
    $sql="delete from user where username='$username'";
    $result = $conn->query($sql);
}



$sql = "SELECT username,firstname,lastname FROM user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>Username</th><th>First Name</th><th>Last Name</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["username"]. "</td>
        <td>" . $row["firstname"]. "</td><td>" . $row["lastname"]."</td>
        <td><a href='login_page_database.php?username=".$row["username"]."'>Delete</a>"."</td>
        <td><a href='register.php?edit=".$row["username"]."'>Edit</a>"."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}




$conn->close();


?>
<br>
<button value="Logout"  onclick="myLink()" >Log Out</button>
<script>
function myLink(){
window.location.assign("ezdine_login_page.php");
alert("Log out Successfully");
}
</script>

</body>
</html>
