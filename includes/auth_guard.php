<?php
session_start([
    'cookie_lifetime' => 28800,
    'gc_maxlifetime' => 28800,
    'cookie_path' => '/',
    'cookie_secure' => !empty($_SERVER['HTTPS']),
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);
require_once __DIR__.'/../classes/UserManager.php';
$um = new UserManager(__DIR__.'/../data/users.json');

if (!isset($_SESSION['userid'])) {
    header('Location: /index.php'); exit;
}

$userId = (int)$_SESSION['userid'];
$user = $um->findById($userId);
if (!$user) {
    $_SESSION = [];
    session_destroy();
    header('Location: /index.php'); exit;
}
