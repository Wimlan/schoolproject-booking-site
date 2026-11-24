<?php
require_once __DIR__.'/../classes/UserManager.php';
$um = new UserManager(__DIR__.'/../data/users.json');

if (!isset($_COOKIE['userid'])) {
    header('Location: /index.php'); exit;
}

$userId = (int)$_COOKIE['userid'];
$user = $um->findById($userId);
if (!$user) {
    // ogiltig kaka → ta bort och redirect
    setcookie('userid', '', time()-3600, '/');
    header('Location: /index.php'); exit;
}
