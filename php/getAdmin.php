<?php // returns whether the user is an admin of the forum/site
require_once 'connection.php';
session_start();
if (isset($_SESSION['username']) && $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['forumname'])) {
    $pdo = connectdb();
    $username = $_SESSION['username'];
    $forumname = $_GET['forumname'];

    $sql = "SELECT siteadmin FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    if($stmt->fetch()['siteadmin'] == 1){
        echo(json_encode(array(1)));
    }
    else{
        $sql = "SELECT isadmin FROM inforum WHERE forumname = ? AND username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$forumname, $username]);
        if($user = $stmt->fetch()){
            if($user['isadmin'] == 1){
                echo(json_encode(array(1)));
            }
            else{
                echo(json_encode(array(0)));
            }
        }
        else{
            echo(json_encode(array(0)));
        }
    }


} else {
    echo(json_encode(array(0)));
}
?>