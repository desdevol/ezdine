<?php
session_start();
include("logout.php");
include("config.php");
include("userAccess.php");
?>

<!DOCTYPE html>

<html id="purchaseorder">
<head>
<title>Purchase Order</title>

<!--Minor CSS-->
<style type="text/css">
  table, th, td {
    border: 1px solid black;
}
</style>
<!--Icon-->
<link rel="icon" type="image/gif" href="img/EZDine-logo.png">
<link rel="stylesheet" href="iconpack/iconworks/flaticon.css">
<!--ez dine css-->
<link rel="stylesheet" type="text/css" href="ezdine.css">
<link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">

<!--Google Font-->
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

<!--CSS-->
<link rel="stylesheet" type="text/css" href="supplier.css">


</head>

<!--Body-->
<body>

<!--Sidenav-->
<ul class="sidenav">
  <li class="sidenavitem"><img src="img/EZDine-logo.png" class="sidenavlogo"></li>
  <li class="sidenavitem"><a href="index.php">Main Menu</a></li>
  <li class="sidenavitem"><a href="menu.php">Menu</a></li>
  <li class="sidenavitem"><a href="payment_history.php">Payment History</a></li>
  <li class="sidenavitem"><a href="table.php">Table Management</a></li>
  <li class="sidenavitem"><a href="inventory.php" class="active">Inventory Management</a></li>
  <li class="sidenavitem"><a href="employee.php">Employee Management</a></li>
  <li class="sidenavitem"><a href="sales.php"> Sales Report</a></li>
</ul>

<!--content put in this div-->
<!--Container-->
<div class="pagecontainer">
 <!--Page title-->
 <div class="pagetitle">
    <h1>Purchase Order</h1>
    <!--Log Out Button-->
    <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='purchaseorder.php?username=logout'">
    <!--Setting-->
    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>
 </div>

  <!--Page contents-->
    <div class="pagecontent">
      <!--Modal-->
      <div id="addPO" class="modal">
        <!--Insert Job Position Modal -->
        <div class="modal-content">
          <span class="close">&times;</span>
          <form method="post" action="inventoryRedirect.php">
            <label id="asklbl">Enter the amount of item to order:</label><br><br>
            <input type="text" name="POid" id="POid" value="" hidden>
            <input type="number" name="amount" id="inputAmount" required>
            <button id="addPOBtn" name="addPO" title="Add PO">+</button>
          </form>
        </div>
      </div>

    <!--Back Button-->
    <a href="inventory.php" class="menubtn" style="font-size: 20px;">Back</a>
    <!--Add Supplier Button-->
    <a href="insertsupplier.php" class="menubtn" style="font-size: 20px;"><i class="flaticon-user-outline"></i> Add Supplier</a>
    <form method="get" action="purchaseorder.php">
      <input type="text" name="search" id="searchBox" placeholder="ID or Item Name">
      <button id="searchBtn">Search</button><br><br>
    </form>
<?php
//delete
if(isset($_GET['del'])){
    $supplierid=$_GET['del'];
    $sql="DELETE from supplier where supplierid='$supplierid'";
    $result = $conn->query($sql);
    header("Location: purchaseorder.php");
}

//Select & display
$sql = "SELECT supplierid,itemname,measurement,price,suppliername FROM supplier";
$result = $conn->query($sql);

//Search
if(isset($_GET['search'])){
  if($_GET['search']==""){
    header("Location: purchaseorder.php");
  }
  else{
    $search=$_GET['search'];
    $sql="SELECT * FROM supplier WHERE supplierid LIKE '%$search%' OR itemname LIKE '%$search%'";
    $result = $conn->query($sql);
  }
}

if ($result->num_rows > 0) {
    echo "<table><tr>
    <th class=\"straightth\">ID</th>
    <th class=\"straightth\">Item</th>
    <th class=\"straightth\">Measurement</th>
    <th class=\"straightth\">Price/unit (RM)</th>
    <th class=\"straightth\">Supplier</th>
    <th colspan=\"3\" class=\"straightth\">Functions</th>
    </tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row["supplierid"]. "</td>
        <td>" . $row["itemname"]. "</td>
        <td>" . $row["measurement"]."</td>
        <td>" . $row["price"]."</td>
        <td>" . $row["suppliername"]."</td>

        <td class='center'><a class=\"link\" title='Add PO' onclick='addPO(".$row["supplierid"].")'><i class='flaticon-clipboard'></i></a></td>
        <td class='center'><a class=\"link\" href='purchaseorder.php?del=".$row["supplierid"]."' title='Delete'><i class='flaticon-rubbish-bin'></i></a>"."</td>
        <td class='center'><a class=\"link\" href='insertsupplier.php?edit=".$row["supplierid"]."' title='Edit'><i class='flaticon-pencil-outline'></i></a>"."</td>
        </tr> ";
    }
    echo "</table>";
} else {
    echo "No supplier information.";
}

$conn->close();
?>
    </div>

</div>

</body>
</html>

<script type="text/javascript">
function addPO(id){
  modal.style.display = "block";
  document.getElementById('POid').value = id;
}
//---------------------Modal--------------------------
var modal = document.getElementById('addPO');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
