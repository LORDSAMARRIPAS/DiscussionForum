<?php
require_once 'connection.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_FILES['image'])) {
    echo "Error uploading image";
    exit();
}
// Check if the file was uploaded without errors
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Get the temporary file path
    $tmpFilePath = $_FILES['image']['tmp_name'];

    // Read the file contents
    $fileContent = file_get_contents($tmpFilePath);

    // Check if the file is an image
    if (getimagesize($tmpFilePath)) {
        // Convert the file contents to a blob
        session_start();
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