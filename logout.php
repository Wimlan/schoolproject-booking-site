<?php
session_start([
    'cookie_lifetime' => 28800,
    'gc_maxlifetime' => 28800,
    'cookie_path' => '/',
    'cookie_secure' => !empty($_SERVER['HTTPS']),
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);
$_SESSION = [];
setcookie(session_name(), '', [
    'expires' => time() - 3600,
    'path' => '/',
    'secure' => !empty($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_destroy();
header('Location: index.php'); exit;
