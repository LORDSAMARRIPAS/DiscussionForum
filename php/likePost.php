<?php
require_once 'connection.php';
session_start();

if(!isset($_SESSION['username'])){
    header("location: ../views/login.html");
    exit();
}else{
    $username = $_SESSION['username'];
}
require_once 'csrf.php';
if(!$_SERVER['REQUEST_METHOD'] === 'POST' || !isset($_POST['postid'])){
    header("location: ../views/forumPage.html");
    exit();
}
requireCsrf();
$postid = $_POST['postid'];

$pdo = connectdb();
if(!$pdo){
    echo "Error connecting to database";
    exit();
}

$sql = "INSERT INTO hasliked (username, postid) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username, $postid]);


header("location: ../views/Home.html");
exit();

?>