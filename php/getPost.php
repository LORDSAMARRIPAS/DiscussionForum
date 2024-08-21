<?php
require_once 'connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['postId'])) {

    $postId = $_GET['postId'];
    
    $pdo = connectdb();
    $sql = "SELECT posttitle, posttext FROM posts WHERE postid = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$postId]);
    $post = $stmt->fetchAll();
    
    echo(json_encode($post));

} else {
    echo(json_encode(array(0)));
}
?>