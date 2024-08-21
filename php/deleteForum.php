<?php
require_once 'connection.php';
session_start();

if(!isset($_SESSION['username'])){
    header("location: ../views/login.html");
    exit();
}else{
    $username = $_SESSION['username'];
}
if($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['forumname'])){
    header("location: ../views/Home.html");
    exit();
}
$forumname = $_POST['forumname'];

$pdo = connectdb();
if(!$pdo){
    header("location: ../views/Home.html");
    exit();
}
$sql = "SELECT ownername FROM forums WHERE forumname = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$forumname]);
if($user = $stmt->fetch()){
    if($user['ownername'] == $username){
        $sql = "DELETE FROM forums WHERE forumname = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$forumname]);
        header("location: ../views/Home.html");
        exit();
    }
    else{
        $sql = "SELECT siteadmin FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        if($stmt->fetch()['siteadmin'] == 1){
            $sql = "DELETE FROM forums WHERE forumname = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$forumname]);
            header("location: ../views/Home.html");
            exit();
        }
    }
    header("location: ../views/forumPage.html?forumname=$forumname");
    exit();
}
else{
    header("location: ../views/forumPage.html?forumname=$forumname");
    exit();
}
?>