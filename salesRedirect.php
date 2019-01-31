<?php
include("config.php");

if (isset($_POST['PDF'])) {

  $month = $_POST['month'];
  $date = $_POST['date'];

  require_once 'pdf.php';


  $output = "
  <html>
    <head>
    <link type='text/css' href='pdfTable.css' rel='stylesheet'>
    </head>
    <body>";
  //Get total food sale from payhistory
  $sql = "SELECT SUM(total) AS totalSale, COUNT(payID) AS numOfSale FROM payhistory WHERE SUBSTRING(date, 1, 7) = '$month'";
  $result = $conn->query($sql);
  if($result->num_rows > 0){ //If has sale for that month
    while ($row = $result->fetch_assoc()) {
      $output = "<h2>Monthly Sale: ".$date."</h2>
        <h3>Total Sale: RM ".$row['totalSale']."<br>Sales Completed: ".$row['numOfSale']."</h3>";
    }

    //Get the sale of each food
    $sql_allFood = "SELECT foodid, foodname FROM menu;";
    $result_allFood = $conn->query($sql_allFood);

    $output .= "<h2>Food Sale</h2>
      <table cellspacing='0' border='1' class='saleTable' width='100%'>
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
    $output .= "</div>";

    $output .= "
      </body>
    </html>
    ";
    $pdf = new Pdf();
    $file_name = 'Sales.pdf';
    $pdf->loadHtml($output);
    $pdf->render();
    $pdf->stream($file_name, array("Attachment" => false));
  }

}
?>
