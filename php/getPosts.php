<?php
require_once 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['forumname'])) {
    $forumname = $_GET['forumname'];
    $pdo = connectdb();
    

    // Retrieve posts for the specified forum

    $sql = "SELECT postid, username, posttitle, posttext, postdate FROM posts WHERE forumname = ? ORDER BY postdate DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$forumname]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if each post has been liked by the current user
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $likedPosts = []; // Array to store liked post IDs
        $stmt = $pdo->prepare("SELECT postid FROM hasliked WHERE username = ?");
        $stmt->execute([$username]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $likedPosts[] = $row['postid'];
        }

        // Add a 'liked' field to each post indicating if it has been liked by the user
        foreach ($posts as &$post) {
            $post['liked'] = in_array($post['postid'], $likedPosts);
        }
        unset($post); // Unset the reference to avoid unexpected behavior
    }

    // Return JSON response including posts and their like status
    echo json_encode($posts);
} else {
    // Return error response if forumname is not provided
    echo json_encode(array('success' => false, 'message' => 'Forum name is required.'));
}
?>
