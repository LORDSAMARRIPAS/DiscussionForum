<?php
require_once 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pdo = connectdb();

    if (isset($_SESSION['username'])) {
        // If the user is logged in, retrieve the forums the user is in
        $username = $_SESSION['username'];
        $stmt = $pdo->prepare("SELECT forumname FROM inforum WHERE username = ?");
        $stmt->execute([$username]);
        $followedForums = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Fetch posts from the forums the user is in
        if (!empty($followedForums)) {
            $sql = "SELECT postid, forumname, username, posttitle, posttext, postdate FROM posts WHERE forumname IN (" . str_repeat('?,', count($followedForums) - 1) . "?) ORDER BY postdate DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($followedForums);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // No forums followed, return an empty array
            $posts = [];
        }
    } else {
        // If the user is not logged in, fetch all posts
        $stmt = $pdo->query("SELECT postid, forumname, username, posttitle, posttext, postdate FROM posts ORDER BY postdate DESC");
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Return JSON response including posts
    echo json_encode($posts);
} else {
    // Return error response if forumname is not provided
    echo json_encode(array('success' => false, 'message' => 'Forum name is required.'));
}
?>
