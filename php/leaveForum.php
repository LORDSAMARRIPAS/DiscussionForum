<?php
require_once 'connection.php';
session_start();

if(!isset($_SESSION['username'])){
    header("location: ../views/login.html");
    exit();
}else{
    $username = $_SESSION['username'];
}
if($_SERVER['REQUEST_METHOD'] != 'GET' || !isset($_GET['forumname'])){
    header("location: ../views/Home.html");
    exit();
}
$forumname = $_GET['forumname'];

$pdo = connectdb();
if(!$pdo){
    echo "Error connecting to database";
    exit();
}
$sql = "SELECT ownername FROM inforum JOIN forums ON inforum.forumname=forums.forumname WHERE inforum.forumname = ? AND username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$forumname, $username]);
if($user = $stmt->fetch()){
    if($user['ownername'] == $username){
        echo "<script>alert('Owner cannot leave forum without transferring ownership or deleting forum.'); window.location.href = '../views/forumPage.html?forumname=$forumname';</script>";
        exit();
    }
    else{
        $sql = "DELETE FROM inforum WHERE forumname = ? AND username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$forumname, $username]);
    }

    header("location: ../views/forumPage.html?forumname=$forumname");
    exit();
}
else{
    header("location: ../views/forumPage.html?forumname=$forumname");
    exit();
}
?>