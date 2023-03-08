<?php
session_start();
error_reporting(0);

if($_SESSION['role']==="user"||$_SESSION['role']==="admin"){
    echo"session id :". $_SESSION["id"]."<br>";
    echo "session role :". $_SESSION["role"]."<br>"; 
}
else if($_SESSION['role']!="admin"||$_SESSION['role']!="user"){
    header('location:logout.php');
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>user</h1>
    <a href="logout.php">logout</a>
</body>
</html>