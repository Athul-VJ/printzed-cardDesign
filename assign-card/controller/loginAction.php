<?php
session_start();
include("../model/class.php");
$email = $_POST['emailid'];
$track = $_POST['trackid'];
$obj = new operation();
$obj->login($email,$track);
$result = $obj->executeQuery();
$count = $result->num_rows;
if($count == 1){
    $row = $result->fetch_assoc();
    $_SESSION['trackid'] = $row['trackid'];
    $_SESSION['flag'] = $row['flag'];
    $_SESSION['name'] = $row['name'];
    header('location:../view/main.php');
}else{
    echo "failed";
}

?>