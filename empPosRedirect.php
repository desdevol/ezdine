<?php
include("config.php");

//Add new emp position
if( isset($_POST['addPos']) ) {
  $position = $_POST['jobPosition'];
  $sql = "INSERT INTO emp_position (position) VALUES ('$position')";
  $result = $conn->query($sql);
  if(!$result)
      die($conn->error);
  echo "<script>window.location.href ='empPos.php'</script>";
}

//Check for add
if(isset($_POST['check_position'])){
  $inputPos = $_POST['check_position'];
  $sql = "SELECT * FROM emp_position WHERE position = '$inputPos'";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    echo '<br><span style="color: #ff3030;">&times Job position already existed.</span><br>';
  }
  else{
    echo '<br><span style="color: #5bff5b;">&#10004 Job position input is available.</span><br>';
    echo '<button id="addPosBtn" name="addPos" class="redBtn bigBtn">+</button>';
  }
}

//Check job position for edit
if(isset($_POST['checkedit'])){
  $inputPos = $_POST['checkedit'];
  $sql = "SELECT * FROM emp_position WHERE position = '$inputPos'";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    echo '<br><span style="color: #ff3030;">&times Job position already existed.</span><br>';
  }
  else{
    echo '<br><span style="color: #5bff5b;">&#10004 Job position input is available.</span><br>';
    echo '<button id="editPosBtn" name="editPos" class="redBtn bigBtn"><i class="flaticon-save-file-floppy-disk"></i></button>';
  }
}

//Edit position
if( isset($_POST['editPos']) ) {
  $id = $_POST['posEditID'];
  $position = $_POST['jobPosition'];
  $sql = "UPDATE emp_position SET position = '$position' WHERE ID = '$id'";
  $result = $conn->query($sql);
  if(!$result)
      die($conn->error);
  echo "<script>window.location.href ='empPos.php'</script>";
}
?>
