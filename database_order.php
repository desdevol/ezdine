<!DOCTYPE html>
<html>
<head>
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

    if (isset($_POST['foodid'])){
    $foodid=$_POST['foodid'];
    $foodname=$_POST['foodname'];
    $price=$_POST['price'];
    $foodtype=$_POST['foodtype'];

    $sql="insert into orderdetail values ('$foodid','$foodname','$price','$foodtype')";

    $result = $conn->query($sql);
}

    $sql = "SELECT foodid,foodname,price,foodtype FROM orderdetail";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    echo "<table><tr><th>foodid</th><th>foodname</th><th>price</th><th>foodtype</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["foodid"]. "</td><td>" . $row["foodname"]. "</td><td>" . $row["price"]."</td><td>" . $row["foodtype"]. "</td></tr>";
    }
    echo "</table>";
    } 
    else 
    {
        echo "0 results";
    }

    $conn->close();

    ?>