<?php

include_once("connection.php");

$username = $_REQUEST['usernames']);
$password = $_REQUEST['password']);

//validare de back
function validationFunction($toCheck){
  if($toCheck == ""){
    return false;
  }else if (strlen($toCheck) < 4 || strlen($toCheck) > 10){
    return false;
  }
  return true;
}

if(validationFunction($username) && validationFunction($password)){
  $res=mysqli_query($conn,"SELECT username FROM userdata WHERE username = '$username'");
  $row = mysqli_num_rows($res);
  if($row > 0){
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $ResultSet = $conn -> query("SELECT password FROM userdata WHERE username = '$username'");
      if($value = $ResultSet -> fetch_assoc()){
        $dbPassword = $value["password"];
        $verify = password_verify($password, $dbPassword);
        if($verify){
          echo json_encode(array("statusCode" => 200));
        } else{
          echo json_encode(array("statusCode" => 201));
        }
    }
  }
  else {
    // username gresit
    echo json_encode(array("statusCode" => 201));
  }
  mysqli_close($conn);
}else {
  echo json_encode(array("statusCode" => 201));
}


?>
