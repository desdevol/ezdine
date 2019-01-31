<?php
include("config.php");

//Insert supplier
if(isset($_POST['submit'])){
  $itemname=$_POST['itemname'];
  $measurement=$_POST['measurement'];
  $price=$_POST['price'];
  $suppliername=$_POST['suppliername'];
  //Insert into supplier database
  $sql="INSERT into supplier (itemname, measurement, price, suppliername) values ('$itemname','$measurement','$price','$suppliername')";
  $result = $conn->query($sql);
  header("Location: purchaseorder.php");
}

//Edit supplier
if(isset($_POST['edit'])){
  $supplierid=$_POST['supplierid'];
  $itemname=$_POST['itemname'];
  $measurement=$_POST['measurement'];
  $price=$_POST['price'];
  $suppliername=$_POST['suppliername'];
  //Update supplier database with new edited data
  $sql="UPDATE supplier SET itemname = '$itemname', measurement = '$measurement', price = '$price', suppliername = '$suppliername' WHERE supplierid = '$supplierid'";
  $result = $conn->query($sql);
  header("Location: purchaseorder.php");
}

//Add PO
if (isset($_POST['addPO'])) {
  $supplierid = $_POST['POid'];
  $amount = $_POST['amount'];

  //Get info of supplier from database
  $sql = "SELECT * FROM supplier WHERE supplierid = '$supplierid'";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
      $itemname=$row['itemname'];
      $measurement=$row['measurement'];
      $price=$row['price'];
      $suppliername=$row['suppliername'];
    }
    //Calculate the total price
    $totalprice = $amount * $price;
  }
  //Save into inventory database
  $sql = "INSERT INTO inventory (supplierid, itemname, measurement, price, suppliername, quantity, totalprice) VALUES ('$supplierid', '$itemname', '$measurement', '$price', '$suppliername', '$amount', '$totalprice')";
  $result = $conn->query($sql);
  header("Location: inventory.php");
}
?>
