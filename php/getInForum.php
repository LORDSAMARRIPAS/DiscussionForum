<?php // retrieves a list of forums that the user is in
require_once 'connection.php';
session_start();
if (isset($_SESSION['username'])) {
    
    $pdo = connectdb();
    $sql = "SELECT forumname, isadmin FROM inforum WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['username']]);
    $forums = $stmt->fetchAll();
    if (count($forums) == 0) {
        echo(json_encode(array(0)));
        exit();
    }
    echo(json_encode($forums));

} else {
    echo(json_encode(array(0)));
}
?>