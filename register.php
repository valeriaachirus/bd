<?php
include_once("connection.php");
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$email = mysqli_real_escape_string($conn, $_POST['email']);

function validationFunction($toCheck){
    if($toCheck == ""){
      return false;
    }else if (strlen($toCheck) < 4 || strlen($toCheck) > 10){
      return false;
    }
    return true;
  }

  function emailValidation($mail){
    if($mail == ""){
      return false;
    } else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $mail)){
      return false;
    }
    return true;
  }

  if(validationFunction($username) && validationFunction($password) && emailValidation($email)){
    $res = mysqli_query($conn,"SELECT username FROM users WHERE username = '$username'");
    $row = mysqli_num_rows($res);
    if($row > 0){
        echo json_encode(array("statusCode" => 201));
    }
    else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users VALUES('','$username', '$email', '$hash')";
      if( mysqli_query($conn,$sql)){
        echo json_encode(array("statusCode" => 200));
      }
      else {
        echo json_encode(array("statusCode" => 201));
      }
      mysqli_close($conn);
    }
  }else {
    echo json_encode(array("statusCode" => 201));
  }
?>