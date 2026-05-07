<?php
session_start();
if(!isset($_SESSION['username'])){
    header("location: ../views/login.html");
    exit();
}
?>