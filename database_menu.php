<!DOCTYPE html>
<html>
<head>
    <title>Menu_database</title>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>
    

    <?php

    include("config.php");

    if (isset($_POST['foodid'])){
        $foodid=$_POST['foodid'];
        $foodname=$_POST['foodname'];
        $price=$_POST['price'];
       
        $sql="insert into menu values ('$foodid','$foodname','$price')";

        $result = $conn->query($sql);
    }

    if (isset($_POST['edit'])){
        $foodid=$_POST['foodid'];
        $foodname=$_POST['foodname'];
        $price=$_POST['price'];

    $sql="update menu set foodid='$foodid',foodname='$foodname',price='$price' where foodid='$foodid'"; // update SQL
    $result = $conn->query($sql);
    } 


    if(isset($_GET['foodid'])){
        $foodid=$_GET['foodid'];
        $sql="delete from menu where foodid='$foodid'";
        $result = $conn->query($sql);
    }

    //step2 for search
    $search = "";

    if(isset($_POST['search'])){
        $search = $_POST['search'];
        $search = "where foodname like'%$search%'  or foodid like '%$search%' ";
    }


    $sql = "SELECT foodid,foodname,price FROM menu ".$search ;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    echo "<table><tr><th>Food ID</th><th>Food Name</th><th>Food Price</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["foodid"]. "</td><td>" . $row["foodname"]. "</td><td>" . $row["price"]."</td><td><a href='database_menu.php?id=".$row["foodid"]."'>Delete</a>"."</td><td><a href='insert_menu.php?edit=".$row["foodid"]."'>Edit</a>"."</td></tr>";
    }
    echo "</table>";
    } 
    else 
    {
        echo "0 results";
    }

    $conn->close();

    ?>


    </body>
    </html>

    <!DOCTYPE html>
    <html>
    <head>
    <title></title>
    <style>
    table,th,th
    {
    border:1px solid black;
    }
    </style>
    </head>
    <body>

    <form name="search" action="database_menu.php" method="POST">
        <input type="text" name="search" id="search" />
        <input type="submit" name="searchbtn" value="$search" />
    </form>


    </body>
    </html>

    <!DOCTYPE html>
    <html>
    <head>
    <style>
    table 
    {
        width: 100%;
        border-collapse: collapse;
    }

    table, td, th 
    {
        border: 1px solid black;
        padding: 5px;
    }

    th 
    {
        text-align: left;
    }
    </style>
    </head>
    <body>

