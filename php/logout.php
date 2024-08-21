<?php
session_start();
unset($_SESSION['username']);
header("location: ../views/login.html");
exit();
?>