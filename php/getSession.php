<?php
session_start();
$safe = $_SESSION;
unset($safe['csrf_token']);
echo(json_encode($safe));
unset($_SESSION['errors']);
?>