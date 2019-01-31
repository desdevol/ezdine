<?php
include("config.php");

//1 second interval refresh Chef's page
if (isset($_POST['refresh'])) {
  //Retrieve data from orders database
  $sql = "SELECT * FROM orders LEFT JOIN tablemng ON orders.tableID = tablemng.tableID";
  $result = $conn->query($sql);
  //If has order
  if($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
      $tableID = $row['tableID'];


      //Get food details from table_orders
      $sql_food = "SELECT * FROM table".$tableID."_order WHERE status = 0";
      $result_food = $conn->query($sql_food);

      //If contain food that is not archived
      if($result_food->num_rows > 0){
        echo "<div class='tableBox'>
        <h2 class='tablenumber'>".$row['tableNum']."<h2><hr>";

        while($foodrow = $result_food->fetch_assoc()){
          echo "<div class='displayedFood'>".$foodrow['foodname']."</div>
          <div class='displayedQty'>".$foodrow['quantity']."</div>
          <button class='dump'name='dump".$foodrow['foodid']."' onclick='dump(".$foodrow['id'].", ".$tableID.")'>Dump</button><br>";
        }
        echo "</div>";
      }
    }
  }
  else {
    echo "<h2 style='margin-top: 5%; text-align: center'>No order at the moment.</h2>";
  }
}

//Archive a food
if (isset($_POST['dump'])) {
  $tableID = $_POST['tableid'];
  $foodid = $_POST['foodid'];

  echo $sql = "UPDATE table".$tableID."_order SET status = 1 WHERE id = '$foodid' ";
  $result = $conn->query($sql);

}
?>
