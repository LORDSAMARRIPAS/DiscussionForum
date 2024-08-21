<?php
require_once 'connection.php';
session_start();
if(isset($_SESSION['username'])){
    $pdo = connectdb();
    $sql = "SELECT username, email, phone, firstname, lastname FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt -> fetch();
    echo(json_encode($user));
}
else{
    echo(json_encode(array(0)));
}

?>