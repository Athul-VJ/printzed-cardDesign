<?php
session_start();
$track=$_SESSION['trackid'];
include("../model/class.php");
$obj = new operation();
$obj->UpdateFlag($track);
$result = $obj->executeQuery();
$_SESSION['flag']=1;
header('location:main.php?id=1');
?>
