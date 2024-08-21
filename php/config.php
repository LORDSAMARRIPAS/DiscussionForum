<?php
// config.php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$path = realpath(dirname(__FILE__));
$path = str_replace($root, '', $path); // create generic path which ignores the file root

$path = str_replace('home/', '', $path);
$path = str_replace('public_html/', '', $path); // workaround to make it work on server


$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
define('BASE_URL', $protocol . $domainName . $path . '/..');

?>
