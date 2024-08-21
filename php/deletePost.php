<?php
require_once 'connection.php';
session_start();

if(!isset($_SESSION['username'])){
    header("location: ../views/login.html");
    exit();
}else{
    $username = $_SESSION['username'];
}
if($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['forumname']) || !isset($_POST['postid'])){
    header("location: ../views/Home.html");
    exit();
}
$forumname = $_POST['forumname'];
$postid = $_POST['postid'];

$pdo = connectdb();
if(!$pdo){
    header("location: ../views/Home.html");
    exit();
}
// check if the user is an admin of the forum or site
$sql = "SELECT siteadmin FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
if($stmt->fetch()['siteadmin'] != 1){
    $sql = "SELECT isadmin FROM inforum WHERE forumname = ? AND username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$forumname, $username]);
    if($user = $stmt->fetch()){
        if($user['isadmin'] != 1){
            header("location: ../views/Home.html");
            exit();
        }
    }
    else{
        header("location: ../views/Home.html");
        exit();
    }
}
// user is verified: delete the post
$sql = "DELETE FROM posts WHERE forumname = ? AND postid = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$forumname, $postid]);

header("Location: {$_SERVER['HTTP_REFERER']}");//redirect back to the previous page
exit();
    
?>