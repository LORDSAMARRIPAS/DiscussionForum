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
    header("location: ../views/createForum.html");
    exit();
}
$forumname = $_POST['forumname'];

if(!preg_match("/^[a-zA-Z0-9'_ -]{1,30}$/", $forumname)){
    $_SESSION['errors']['forumname'] = 'Name limited to 30 characters; letters, numbers, hyphen(-), underscore(_), apostrophe(\')';
}

if(isset($_SESSION['errors'])){
    header("location: ../views/createForum.html?errors=1");
    exit();
}

$pdo = connectdb();
if(!$pdo){
    echo "Error connecting to database";
    exit();
}
$sql = "SELECT forumname FROM forums WHERE forumname = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$forumname]);
if($stmt->fetch()){
    $_SESSION['errors']['forumname'] = 'Forum name taken';
    header("location: ../views/createForum.html?errors=1");
    exit();
}
else{
    $sql = "INSERT INTO forums (forumname, ownername, creationdate) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$forumname,$username,Date("Y-m-d H:i:s")]);

    $sql = "INSERT INTO inforum (username, forumname, isadmin, joindate) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username,$forumname,True, Date("Y-m-d H:i:s")]);

    header("location: ../views/forumPage.html?forumname=$forumname");
    exit();
}
?>