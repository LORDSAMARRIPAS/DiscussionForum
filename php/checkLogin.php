<?php
session_start();
if(!$_SESSION['username']){
    header("location: ../views/login.html");
    exit();
}
?>