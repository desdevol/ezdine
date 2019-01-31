<?php
    session_start();
    include("config.php");
    include("logout.php");

    $userName = $_SESSION['ezdineUid'];
    $sql="SELECT type FROM user WHERE username = '$userName'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $type = $row['type'];

    //If not a chef account visits this page
    if($type != 'chef'){
      if($type == 'employee'){
        header("Location: staff/index.php");
      }
      else if ($type == 'admin') {
        header("Location: index.php");
      }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chef Order Display</title>
    <!--CSS-->
    <link rel="stylesheet" href="chef.css">
    <link rel="stylesheet" type="text/css" href="iconpack/iconworks/flaticon.css">
    <!--Logo and Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="icon" type="image/gif" href="img/EZDine-logo.png">
    <!--Scripts-->
    <script type="text/javascript" src="Jquery/jquery.js"></script>
  </head>
  <body>
    <div class="pagetitle">
      <h1>Chef Order Display</h1>
      <!--Logout-->
      <input type="submit" class="logout" value="Log Out" id="logout" name="logout" onclick="window.location.href='chef.php?username=logout'">
      <!--Setting-->
      <a href="chefSetting.php" class="setting"><i class="flaticon-settings-cogwheel"></i></a>
    </div>
    <div id="pageContent">
    <?php
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
    ?>
    </div>

  </body>
</html>

<script type="text/javascript">
//Refresh with AJAX every second
refreshChef();
function refreshChef() {
  var url = "chefRedirect.php";
  setInterval(function(){
      $.ajax({
         type: 'POST',
         url: url,
         data: "refresh",
         success: function(result) {
           $("#pageContent").html(result);
         },
         error: function() {
           console.log("AJAX call failed");
         }
      })
  }, 1000);
}

function dump(foodid, tableid){
  var url = "chefRedirect.php";
  var foodid = foodid;
  var tablid = tableid;

  $.ajax({
     type: 'POST',
     url: url,
     data: {dump: 'dump', foodid: foodid, tableid: tableid},
     success: function(result) {
       console.log(foodid+" is dumped from table "+tableid);
     },
     error: function() {
       console.log("AJAX call failed");
     }
  });
}
</script>
