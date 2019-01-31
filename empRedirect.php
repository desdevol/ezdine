<?php
include("config.php");

  //Submit the form
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $ic = $_POST['ic'];
    $email = $_POST['email'];
    $hpno = $_POST['hpno'];
    $telno = $_POST['telno'];
    $gender = $_POST['gender'];
    $race = $_POST['race'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $hash = password_hash($password, PASSWORD_BCRYPT);

    //Save employee data into database
    $sql="INSERT INTO employee (name,ic,email,hpno,telno,gender,race,position,address,username)
    VALUES ('$name','$ic','$email','$hpno','$telno','$gender','$race','$position','$address','$username')"; // update SQL
    $result = $conn->query($sql);

    //If the employee is a chef
    if($position == 'Chef'){
      $sql = "INSERT INTO user (username, password, type) VALUES ('$username', '$hash', 'chef')";
      $result = $conn->query($sql);
    }
    else {
      //Save employee username and password in user database
      $sql = "INSERT INTO user (username, password, type) VALUES ('$username', '$hash', 'employee')";
      $result = $conn->query($sql);
    }
    echo "<script>window.location.href='employee.php'</script>";
  }

  //Check job position if exist
  if(isset($_POST['check_position'])){
    $inputPos = $_POST['check_position'];
    $sql = "SELECT * FROM emp_position WHERE position = '$inputPos'";
    $result = $conn->query($sql);
    echo $result->num_rows;
  }

  //Add new emp position
  if( isset($_POST['addPos']) ) {
    $position = $_POST['addPos'];
    $sql = "INSERT INTO emp_position (position) VALUES ('$position')";
    $result = $conn->query($sql);
    if(!$result)
        die($conn->error);
  }

  //Delete employee
  if( isset($_POST['delEmp']) ) {
    $id = $_POST['delEmp'];
    //Delete employee from employee database
    $sql = "DELETE FROM employee WHERE ID = '$id'";
    $result = $conn->query($sql);

    //Delete employee from user database
    $username = 'stf'.str_pad($id,4,"0",STR_PAD_LEFT);
    $sql = "DELETE FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    if(!$result)
        die($conn->error);
  }

  //Edit employee
  if( isset($_POST['editEmp']) ) {
    $name = $_POST['name'];
    $ic = $_POST['ic'];
    $email = $_POST['email'];
    $hpno = $_POST['hpno'];
    $telno = $_POST['telno'];
    $gender = $_POST['gender'];
    $race = $_POST['race'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $username = $_POST['username'];

    $sql="UPDATE employee SET name = '$name', ic = '$ic', email = '$email',
    hpno = '$hpno', telno = '$telno', gender = '$gender', race = '$race',
    position = '$position', address = '$address' WHERE username = '$username'";
    $result = $conn->query($sql);

    echo "<script>window.location.href='employee.php'</script>";
  }

  //Edit Password
  if (isset($_POST['editPw'])) {
    $id = $_POST["pwid"];
    $username = 'stf'.str_pad($id,4,"0",STR_PAD_LEFT);
    $password = $_POST["password"];
    $hash = password_hash($password, PASSWORD_BCRYPT);

    //Edit password at employee
    $sql = "UPDATE user SET password = '$hash' WHERE username = '$username'";
    $result = $conn->query($sql);
    echo "<script>window.location.href='employee.php'</script>";
  }

?>
