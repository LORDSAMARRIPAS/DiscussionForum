<?php
require_once 'connection.php';
session_start();
if($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['confirmPassword']) || !isset($_POST['email']) || !isset($_POST['phone']) || !isset($_POST['firstName']) || !isset($_POST['lastName'])){
    header("location: ../views/register.html");
    exit();
}
$username = $_POST['username'];
$pass = $_POST['password'];
$pass2 = $_POST['confirmPassword'];
$email = $_POST['email'];
$phone = preg_replace('/[^0-9]/', '',  $_POST['phone']);
// $phone = $_POST['phone'];
$firstname = $_POST['firstName'];
$lastname = $_POST['lastName'];

if(!preg_match("/^[a-zA-Z'-]{1,30}$/",$firstname)){
    $_SESSION['errors']['firstName'] = 'Name limited to 30 characters; letters, hyphen(-), apostrophe(\')';
}
if(!preg_match("/^[a-zA-Z'-]{1,30}$/",$lastname)){
    $_SESSION['errors']['lastName'] = 'Name limited to 30 characters; letters, hyphen(-), apostrophe(\')';
}
if(!preg_match("/^[\w_]{3,15}$/",$username)){
    $_SESSION['errors']['username'] = 'Username must be 3-15 characters using only letters, numbers, or underscores';
}
if(!preg_match("/^\d{10}$/",$phone)){
    $_SESSION['errors']['phone'] = 'Please enter a valid phone number';
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION['errors']['email'] = 'Please enter valid email address';
}
if(!preg_match("/[A-Z]/",$pass) || !preg_match("/[a-z]/",$pass) || !preg_match("/\d/",$pass) || strlen($pass)<6 || strlen($pass)>30){
    $_SESSION['errors']['password'] = 'Please enter a password between 6 and 8 digits including a number and an upper and lowercase letter';
}
if($pass != $pass2){
    $_SESSION['errors']['confirmPassword'] = 'Passwords do not match';
}
if(isset($_SESSION['errors'])){
    header("location: ../views/register.html?errors=1");
    exit();
}

$pdo = connectdb();
if(!$pdo){
    echo "Error connecting to database";
    exit();
}
$sql = "SELECT firstname FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
if($stmt->fetch()){
    $_SESSION['errors']['username'] = 'Username taken';
    header("location: ../views/register.html?errors=1");
    exit();
}
else{
    $pass = md5($pass);
    $sql = "INSERT INTO users (username, pass, siteadmin, startdate, email, phone, firstname, lastname) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username,$pass, false, Date("Y-m-d"),$email,$phone,$firstname,$lastname]);

    $_SESSION['username']=$x['username'];
    header("location: ../views/accountPage.html");
    exit();
}
?>