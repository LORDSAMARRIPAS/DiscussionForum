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
if($_SERVER['REQUEST_METHOD'] != 'GET' || !isset($_GET['forumname']) || !isset($_GET['csrf_token'])){
    header("location: ../views/Home.html");
    exit();
}
if (!validateCsrfToken($_GET['csrf_token'])) {
    header('HTTP/1.1 403 Forbidden');
    echo 'Invalid CSRF token.';
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
        $safe = htmlspecialchars(urlencode($forumname));
        echo "<script>alert('Owner cannot leave forum without transferring ownership or deleting forum.'); window.location.href = '../views/forumPage.html?forumname=$safe';</script>";
        exit();
    }
    else{
        $sql = "DELETE FROM inforum WHERE forumname = ? AND username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$forumname, $username]);
    }

    header("location: ../views/forumPage.html?forumname=" . urlencode($forumname));
    exit();
}
else{
    header("location: ../views/forumPage.html?forumname=" . urlencode($forumname));
    exit();
}
?>