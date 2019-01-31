<?php
session_start();
include("logout.php");
include("config.php");
include("userAccess.php");
include("time.php");
?>


<!DOCTYPE html>
<html>
<head>
<title>Sales Report</title>
<!--Icon-->
<link rel="icon" type="image/gif" href="img/EZDine-logo.png">
<!--Fonts & CSS-->
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="ezdine.css">
<link rel="stylesheet" type="text/css" href="table.css">
<link rel="stylesheet" type="text/css" href="employee.css">
<link rel="stylesheet" type="text/css" href="sales.css">
<link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">
<!--AJAX-->
<script src="Jquery/jquery.js"></script>

<!--Month Picker-->
<script type="text/javascript" src="Jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="Jquery/jquery.mtz.monthpicker.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css">

</head>
<body>

<!--Sidenav-->
<ul class="sidenav">
  <li class="sidenavitem"><img src="img/EZDine-logo.png" class="sidenavlogo"></li>
  <li class="sidenavitem"><a href="index.php">Main Menu</a></li>
  <li class="sidenavitem"><a href="menu.php">Menu</a></li>
  <li class="sidenavitem"><a href="payment_history.php">Payment History</a></li>
  <li class="sidenavitem"><a href="table.php">Table Management</a></li>
  <li class="sidenavitem"><a href="inventory.php">Inventory Management</a></li>
  <li class="sidenavitem"><a href="employee.php">Employee Management</a></li>
  <li class="sidenavitem"><a href="sales.php" class="active"> Sales Report</a></li>
</ul>

<!--Contents put here-->
<div class="pagecontainer">
  <!--Page title (can delete if not wanted)-->
  <div class="pagetitle">
    <h1>Sales Report</h1>
    <!--Log Out Button-->
    <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='sales.php?username=logout'">
    <!--Setting-->
    <a href="setting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>
  </div>

  <!--Page contents-->
  <div class="pagecontent">
    <?php
    //If no month is selected by user
    if (empty($_GET['month'])) {
      echo "
      <form method='get' action='sales.php'>
        <h3 class='monthdisplay'>$today[month] $today[year]</h3>
        <i class='flaticon-calendar'></i><input type='text' id='monthpicker' name='month'>
        <button type='submit' class='smallBtn redBtn' style='padding: 2px 10px;'><i class='flaticon-magnifying-glass'></i></button>
      </form>
      ";

      echo "
      <form action='salesRedirect.php' method='post'>
        <input name='month' value='".$currentMonth."' hidden>
        <input name='date' value='$today[month] $today[year]' hidden>
        <button name='PDF' id='PDF'>PDF</button>
      </form>";

      //Get total food sale from payhistory
      $sql = "SELECT SUM(total) AS totalSale, COUNT(payID) AS numOfSale FROM payhistory WHERE SUBSTRING(date, 1, 7) = '$currentMonth' HAVING totalSale > 0";
      $result = $conn->query($sql);
      if($result->num_rows > 0){ //If has sale for that month
        while ($row = $result->fetch_assoc()) {
          $output = "<div class='saleContainer'>
            <h2>Monthly Sale</h2>
            <div class='totalSale'>RM ".$row['totalSale']."</div>
            <div class='totalSale'>".$row['numOfSale']." Sales</div>
          </div>";
        }

        //Get the sale of each food
        $sql_allFood = "SELECT foodid, foodname FROM menu;";
        $result_allFood = $conn->query($sql_allFood);

        $output .= "<div class='saleContainer'>
          <h2>Food Sale</h2>
          <table class='saleTable' cellspacing='0'>
            <tr><th>Food ID</th><th>Food Name</th><th>Sale</th><th>Quantity Sold</th></tr>";
        while ($row_allFood = $result_allFood->fetch_assoc()){
          $foodid = $row_allFood['foodid'];

          //Get the total sale of each food
          $sql_each = "SELECT a.foodid, a.foodname, SUM(a.price) AS sale, SUM(a.quantity) AS totalQty FROM payment AS a WHERE  SUBSTRING(date, 1, 7) = '$currentMonth' AND a.foodid = '$foodid' GROUP BY a.foodid";
          $result_each = $conn->query($sql_each);
          if($result_each->num_rows > 0){ //has food sale
            while ($row_each = $result_each->fetch_assoc()){
              $output .= "<tr><td class='center'>".$row_each['foodid']."</td><td>".$row_each['foodname']."</td><td class='center'>".$row_each['sale']."</td><td class='center'>".$row_each['totalQty']."</td></tr>";
            }

          }
          else { //no food sale
            $output .= "<tr><td class='center'>".$foodid."</td><td>".$row_allFood['foodname']."</td><td class='center'>0</td><td class='center'>0</td></tr>";
          }
        }
          $output .= "</table>";
        echo $output .= "</div>";
      }
      else{ //If no sale for that month
        echo "
        <div id='noRecord'>
          <i class='flaticon-document-outline'></i><br>
          <h1>No record of sales for this month.</h1>
        </div>
        ";
      }
    }

    //If user selects a month
    if(isset($_GET['month'])){
      $month = $_GET['month'];
      $selectedMonth=date_create($month."/01"); //Create a date for selected month
      $displayMonth=date_format($selectedMonth, "F Y");

      echo "
      <form method='get' action='sales.php'>
        <h3 class='monthdisplay'>".$displayMonth."</h3>
        <i class='flaticon-calendar'></i><input type='text' id='monthpicker' name='month'>
        <button type='submit' class='smallBtn redBtn' style='padding: 2px 10px;'><i class='flaticon-magnifying-glass'></i></button>
      </form>
      ";

      echo "
      <form action='salesRedirect.php' method='post'>
        <input name='month' value='".$month."' hidden>
        <input name='date' value='".$displayMonth."' hidden>
        <button name='PDF' id='PDF'>PDF</button>
      </form>";
      //Get total food sale from payhistory
      $sql = "SELECT SUM(total) AS totalSale, COUNT(payID) AS numOfSale FROM payhistory WHERE SUBSTRING(date, 1, 7) = '$month' HAVING totalSale > 0";
      $result = $conn->query($sql);
      if($result->num_rows > 0){ //If has sale for that month
        while ($row = $result->fetch_assoc()) {
          $output = "<div class='saleContainer'>
            <h2>Monthly Sale</h2>
            <div class='totalSale'>RM ".$row['totalSale']."</div>
            <div class='totalSale'>".$row['numOfSale']." Sales</div>
          </div>";
        }

        //Get the sale of each food
        $sql_allFood = "SELECT foodid, foodname FROM menu;";
        $result_allFood = $conn->query($sql_allFood);

        $output .= "<div class='saleContainer'>
          <h2>Food Sale</h2>
          <table class='saleTable' cellspacing='0'>
            <tr><th>Food ID</th><th>Food Name</th><th>Sale</th><th>Quantity Sold</th></tr>";
        while ($row_allFood = $result_allFood->fetch_assoc()){
          $foodid = $row_allFood['foodid'];

          //Get the total sale of each food
          $sql_each = "SELECT a.foodid, a.foodname, SUM(a.price) AS sale, SUM(a.quantity) AS totalQty FROM payment AS a WHERE  SUBSTRING(date, 1, 7) = '$month' AND a.foodid = '$foodid' GROUP BY a.foodid";
          $result_each = $conn->query($sql_each);
          if($result_each->num_rows > 0){ //has food sale
            while ($row_each = $result_each->fetch_assoc()){
              $output .= "<tr><td class='center'>".$row_each['foodid']."</td><td>".$row_each['foodname']."</td><td class='center'>".$row_each['sale']."</td><td class='center'>".$row_each['totalQty']."</td></tr>";
            }

          }
          else { //no food sale
            $output .= "<tr><td class='center'>".$foodid."</td><td>".$row_allFood['foodname']."</td><td class='center'>0</td><td class='center'>0</td></tr>";
          }
        }
          $output .= "</table>";
        echo $output .= "</div>";
      }
      else{ //If no sale for that month
        echo "
        <div id='noRecord'>
          <i class='flaticon-document-outline'></i><br>
          <h1>No record of sales for this month.</h1>
        </div>
        ";
      }
    }
    ?>
  </div>
</div>

</body>
</html>

<script type="text/javascript">
$('#monthpicker').monthpicker({
  pattern: 'yyyy/mm',
});
</script>
