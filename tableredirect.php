<?php
include("config.php");

      //Set table number------------------------------------------------------
      if (isset($_POST['setnum'])) {
        $numoftable = $_POST['numoftable'];
        if($numoftable>40){ //Check if input is too big
          echo "
          <script>
          alert('Table input is limited to 40.')
          </script>";
        }
        else{
          for ($tablenum=1; $tablenum<=$numoftable ; $tablenum++) {
            $sql="INSERT INTO tablemng (tableID, tableNum) VALUES ('$tablenum','$tablenum')";
            $result = $conn->query($sql);

            //Create a database table for order
            $sql ="CREATE TABLE table".$tablenum."_order(
                  id INT(30) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  foodid INT(30) NOT NULL,
                  foodname VARCHAR(100) NOT NULL,
                  price DOUBLE(20,2) NOT NULL,
                  quantity INT(10) NOT NULL,
                  date VARCHAR(50) NOT NULL,
                  time VARCHAR(50) NOT NULL,
                  status INT(2) NOT NULL
              )";
            $conn->query($sql);
          }
        }
      }

      //Add 1 table----------------------------------------------------------
      $getlastid="SELECT tableID FROM tablemng ORDER BY tableID DESC LIMIT 1";
      $result2 = $conn->query($getlastid);
      $lastnum = 0;
      if ($result2->num_rows > 0) {
        while($row = $result2->fetch_assoc()) {
         $lastnum = $row['tableID'];
        }
      }

      if (isset($_POST['addonetable'])) {
        $sql = "SELECT COUNT(*) FROM tablemng AS total";
        $rs = $conn->query($sql);
        $result = mysqli_fetch_array($rs);
        $numoftable = $result[0];
        if($numoftable>=40){ //Check if input is too big
          echo "
          <script>
          alert('Table input is limited to 40.')
          </script>";
        }
        else{
          $lastnum++;
          $sql="INSERT INTO tablemng (tableID, tableNum) VALUES ('$lastnum','$lastnum')";
          $result = $conn->query($sql);

          //Create a database table for order
          $sql ="CREATE TABLE table".$lastnum."_order(
                id INT(30) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                foodid INT(30) NOT NULL,
                foodname VARCHAR(100) NOT NULL,
                price DOUBLE(20,2) NOT NULL,
                quantity INT(10) NOT NULL,
                date VARCHAR(50) NOT NULL,
                time VARCHAR(50) NOT NULL,
                status INT(2) NOT NULL
            )";
          $conn->query($sql);
        }
      }

      //Delete all table---------------------------------------------------------
      if(isset($_POST['deleteAll'])){
        //Get all the table ID from database
        $sql="SELECT tableID FROM tablemng";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
          while ($row = $result->fetch_assoc()) {
            $sql2 = "DROP TABLE table".$row['tableID']."_order";
            $result2 = $conn->query($sql2);
          }
        }

        $sql="DELETE FROM tablemng";
        $result = $conn->query($sql);
      }

      //Edit table-----------------------------------------------------------
      if(isset($_POST['tabID'])){
        $tableID = $_POST['tabID'];
        $tableNum = $_POST['changeNum'];
        $sql="UPDATE tablemng SET tableNum='$tableNum' where tableID='$tableID'"; // update SQL
        $result = $conn->query($sql);
      }

// Redirect back to table.php
echo "
<script>
window.location.href ='table.php'
</script>
";
?>
