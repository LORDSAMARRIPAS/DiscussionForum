<?php
require_once 'config.php'; 
$pdo;
function connectdb(){
    try {
        $connString = "mysql:host=localhost;dbname=db_37431970";
        $user = "37431970";
        $pass = "37431970";
    
        $pdo = new PDO($connString, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        return $pdo;
    }
    catch(PDOException $e){
        return null;
    }
}

function closedb(){
    $pdo = null;
}

?>