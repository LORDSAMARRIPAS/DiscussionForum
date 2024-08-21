<?php
require_once 'connection.php';
session_start();

if(!isset($_SESSION['username'])){
    header("location: ../views/login.html");
    exit();
}else{
    $username = $_SESSION['username'];
}
if(!$_SERVER['REQUEST_METHOD'] === 'POST' || !isset($_POST['messagetext']) || !isset($_POST['postId']) || !isset($_POST['forumname'])){
    header("location: ../views/forumPage.html");
    exit();
}

$messagetext = $_POST['messagetext'];
$postId = $_POST['postId'];
$forumname = $_POST['forumname'];


$pdo = connectdb();
if(!$pdo){
    echo "Error connecting to database";
    exit();
}

$sql = "INSERT INTO postmessages (forumname, postid, username, messagetext, postdate) VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$forumname, $postId, $username, $messagetext, Date("Y-m-d H:i:s")]);

header("location: ../views/postPage.html?postId=$postId&forumname=$forumname");
exit();

?>