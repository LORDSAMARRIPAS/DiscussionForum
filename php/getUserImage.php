<?php
require_once 'connection.php';
session_start();
if(isset($_SESSION['username'])){
    $pdo = connectdb();
    $sql = "SELECT profileimage FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt -> fetch();

    // Get the image file contents as a string
    $imageData = $user['profileimage'];

    // Convert the image data to a base64-encoded string
    $imageBase64 = base64_encode($imageData);

    // Output the image data as JSON
    header("Content-Type: application/json");
    echo json_encode(['imageData' => $imageBase64]);
}
else{
    echo(json_encode(array(0)));
}
?>