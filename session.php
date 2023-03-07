<?php
session_start();
error_reporting(0);

if($_SESSION['role']==="admin"){
    echo"session id :". $_SESSION["id"]."<br>";
    echo "session password :". $_SESSION["role"]."<br>"; 
}
else if($_SESSION['role']==="user"){
    echo"session id :". $_SESSION["id"]."<br>";
    echo "session password :". $_SESSION["role"]."<br>"; 
}
else if($_SESSION['role']!="admin"||$_SESSION['role']!="user"){
    header('location:logout.php');
}
?>