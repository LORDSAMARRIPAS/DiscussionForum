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
$sql = "SELECT forumname FROM inforum WHERE forumname = ? AND username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$forumname, $username]);
if($stmt->fetch()){
    header("location: ../views/forumPage.html?forumname=" . urlencode($forumname));
    exit();
}
else{
    $sql = "INSERT INTO inforum (username, forumname, isadmin, joindate) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username,$forumname, false, Date("Y-m-d H:i:s")]);

    header("location: ../views/forumPage.html?forumname=" . urlencode($forumname));
    exit();
}
?>