<?php
include('config.php');

//print_invoice.php
if(isset($_GET["pdf"]) && isset($_GET["payID"])){
  require_once 'pdf.php';

  $payID = $_GET['payID'];

  //Get header info from payhistory
  $sql_history = "SELECT * FROM payhistory WHERE payID = '$payID'";
  $result_history = $conn->query($sql_history);
  if($result_history->num_rows > 0){
    while ($row = $result_history->fetch_assoc()) {
      $output = "
      <table cellspacing='0' class='saleTable' width='100%'>
        <tr><th>Table Number: ".$row['tableNum']."</th><th>Payment ID: ".$payID."</th></tr>
        <tr><th>Date: ".$row['date']."</th><th>Time: ".$row['time']."</th></tr>
      </table><hr>";
    }
  }

  //Get all the food info from payment
  $sql = "SELECT * FROM payment WHERE payID = $payID";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $output .= "
      <table table cellspacing='0' class='saleTable' width='100%'>
        <tr><th>Food ID</th><th>Food Name</th><th>Price</th><th>Quantity</th></tr>
        <tr><td colspan='4'>&nbsp;</td></tr>
    ";
    while ($row = $result->fetch_assoc()) {
      $output .= "
        <tr><td>".$row['foodid']."</td><td>".$row['foodname']."</td><td>RM ".$row['price']."</td><td>".$row['quantity']."</td></tr>
      ";
    }
    $output .= "</table>";
  }

  //Get the bill info from payhistory
  $sql_history = "SELECT total, payAmt, payChange FROM payhistory WHERE payID = '$payID'";
  $result_history = $conn->query($sql_history);
  if($result_history->num_rows > 0){
    while ($row = $result_history->fetch_assoc()) {
      $output .= "
      <hr>
      <table cellspacing='0' class='saleTable' width='100%'>
        <tr><th width='50%'></th><th>Total: ".$row['total']."</th></tr>
        <tr><th width='50%'><th>Paid Amount: ".$row['payAmt']."</th></tr>
        <tr><th width='50%'><th>Change: ".$row['payChange']."</th></tr>
      </table><hr>";
    }
  }

  $pdf = new Pdf();
  $file_name = 'Invoice-'.$row["payID"].'.pdf';
  $pdf->loadHtml($output);
  $pdf->render();
  $pdf->stream($file_name, array("Attachment" => false));
}

?>
