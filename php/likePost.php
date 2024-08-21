<?php
require_once 'connection.php';
session_start();

if(!isset($_SESSION['username'])){
    header("location: ../views/login.html");
    exit();
}else{
    $username = $_SESSION['username'];
}
if(!$_SERVER['REQUEST_METHOD'] === 'POST' || !isset($_POST['postid'])){
    
    header("location: ../views/forumPage.html?forumname=Apex");
    exit();
}
$postid = $_POST['postid'];

$pdo = connectdb();
if(!$pdo){
    echo "Error connecting to database";
    exit();
}

$sql = "INSERT INTO hasliked (username, postid) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username, $postid]);


header("location: ../php/Home.php");
exit();

?>