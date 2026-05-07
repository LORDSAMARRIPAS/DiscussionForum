<?php
require_once 'connection.php';
require_once 'csrf.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_FILES['image'])) {
    echo "Error uploading image";
    exit();
}
requireCsrf();

$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// Check if the file was uploaded without errors
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmpFilePath = $_FILES['image']['tmp_name'];
    $origName = $_FILES['image']['name'];
    $extension = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

    // Validate MIME type using finfo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $tmpFilePath);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedMimeTypes)) {
        echo "Error: Invalid file type. Only JPEG, PNG, GIF, and WebP images are allowed.";
        exit();
    }

    if (!in_array($extension, $allowedExtensions)) {
        echo "Error: Invalid file extension.";
        exit();
    }

    // Read the file contents
    $fileContent = file_get_contents($tmpFilePath);

    if (getimagesize($tmpFilePath)) {
        $username = $_SESSION['username'];
        $pdo = connectdb();

        try{
            $sql = "UPDATE users SET profileimage = ? WHERE username = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$fileContent,$username]);
        } catch(PDOException $e){
            if($e->getMessage() == "SQLSTATE[08S01]: Communication link failure: 1153 Got a packet bigger than 'max_allowed_packet' bytes"){
                echo "Error: Image size too large. Please upload an image less than 1MB.";
                exit();
            }
            echo "Error uploading image";
            exit();
        }

        // Call the function userInfo() in the parent window
        echo '<script>window.opener.userImage();</script>';
        echo '<script>window.close();</script>'; // Close the window using JavaScript

    } else {
        echo 'Error: File is not an image.';
    }

} else {
    echo 'Error uploading image.';
}
?>