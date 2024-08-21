<?php
require_once 'connection.php';
session_start();

if(!isset($_SESSION['username'])){
    header("location: ../views/login.html");
    exit();
}else{
    $username = $_SESSION['username'];
}
if(!$_SERVER['REQUEST_METHOD'] === 'POST' || !isset($_POST['posttitle']) || !isset($_POST['posttext']) || !isset($_POST['forumname'])){
    header("location: ../views/forumPage.html");
    exit();
}
$posttitle = $_POST['posttitle'];
$posttext = $_POST['posttext'];
$forumname = $_POST['forumname'];

$pdo = connectdb();
if(!$pdo){
    echo "Error connecting to database";
    exit();
}

$pdo = connectdb();
$sql = "SELECT forumname FROM inforum WHERE username = ? AND forumname = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['username'], $forumname]);
$forums = $stmt->fetchAll();
if (count($forums) == 0) {
    echo "<script>alert('You must join the forum before adding a post.'); window.location.href = '../views/forumPage.html?forumname=$forumname';</script>";
    exit();
}

$sql = "INSERT INTO posts (forumname, username, posttitle, posttext, postdate) VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$forumname,$username, $posttitle, $posttext, Date("Y-m-d H:i:s")]);

header("location: ../views/forumPage.html?forumname=$forumname");
exit();

?>