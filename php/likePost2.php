<?php
// likePost.php

// Include the database connection file
require_once 'connection.php';

// Function to redirect to the login page
function redirectToLogin() {
    header("Location: ../views/login.html"); // Replace 'login.php' with the actual login page URL
    exit; // Stop further execution
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON data sent in the request body
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if the required data (postId) is present in the JSON data
    if (isset($data['postId'])) {
        // Get the postId from the JSON data
        $postId = $data['postId'];

        // Check if the user is logged in (You may need to implement user authentication)
        session_start();
        if (isset($_SESSION['username'])) {
            // Get the username of the current user
            $username = $_SESSION['username'];

            // Connect to the database
            $pdo = connectdb();

            // Check if the user has already liked the post
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM hasliked WHERE username = ? AND postid = ?");
            $stmt->execute([$username, $postId]);
            $count = $stmt->fetchColumn();

            if ($count == 0) {
                // If the user hasn't liked the post yet, insert a new row into the hasliked table
                $stmt = $pdo->prepare("INSERT INTO hasliked (username, postid) VALUES (?, ?)");
                $stmt->execute([$username, $postId]);

                // Return a success message
                echo json_encode(['success' => true]);
            } else {
                // If the user has already liked the post, return a message indicating that
                echo json_encode(['success' => false, 'message' => 'You have already liked this post.']);
            }
        } else {
            // If the user is not logged in, redirect to the login page
            echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        }
    } else {
        // If the postId is not present in the JSON data, return an error message
        echo json_encode(['success' => false, 'message' => 'Post ID is required.']);
    }
} else {
    // If the request method is not POST, return an error message
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
