<?php
require_once 'connection.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['username'])) {
    
    $username = $_SESSION['username'];
    
    $pdo = connectdb();
    
    
    $sql = "SELECT postid FROM hasliked WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $ids = $stmt->fetchAll();
    // $posts = $stmt->fetch();
    echo(json_encode($ids));

} else {
    echo(json_encode(array(0)));
}
?>