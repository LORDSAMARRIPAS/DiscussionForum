<?php
session_start();
echo(json_encode($_SESSION));
unset($_SESSION['errors']);
?>