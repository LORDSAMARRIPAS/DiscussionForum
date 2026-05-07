<?php
session_start();
require "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchValue = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
    if ($searchValue) {
        $pdo = connectdb();
        $query = "SELECT * FROM forums WHERE forumname LIKE :search";
        $stmt = $pdo->prepare($query);
        
        $stmt->execute(['search' => "%{$searchValue}%"]);
        $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $_SESSION['search_results'] = $searchResults;
        header("Location: search.php");
        exit();
    }
    else {
        header("Location: search.php");
        exit();
    }
}
else{
    header("Location: search.php");
    exit();
}
?>
