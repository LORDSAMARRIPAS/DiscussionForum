<?php
require_once 'connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['postId'])) {

    $postId = $_GET['postId'];
    
    $pdo = connectdb();
    $sql = "SELECT username, messagetext,postdate FROM postmessages WHERE postid = ? ORDER BY postdate DESC";  //get the messages for this particular post
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$postId]);
    $post = $stmt->fetchAll();
    
    echo(json_encode($post));

} else {
    echo(json_encode(array(0)));
}
?>