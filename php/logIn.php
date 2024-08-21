<?php
require_once 'connection.php';
session_start();
if($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['username']) || !isset($_POST['password'])){
    header("location: ../views/login.html");
    exit();
}
$username = $_POST['username'];
$pass = $_POST['password'];
$pass = md5($pass);

$pdo = connectdb();
$sql = "SELECT pass FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
if($x = $stmt->fetch()){
    if($pass===$x['pass']){
        $_SESSION['username']=$username;
        header("location: ../views/accountPage.html");
        exit();
    }
    else{
        $_SESSION['errors']['password'] = "Password and username don't match";
        header("location: ../views/login.html?errors=1");
        exit();
    }

}
else{
    $_SESSION['errors']['username'] = "Username not found";
    header("location: ../views/login.html?errors=1");
    exit();
}

?>