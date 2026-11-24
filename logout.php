<?php
// Rensa kaka och redirect
setcookie('userid', '', [
    'expires' => time() - 3600,
    'path' => '/',
]);
header('Location: index.php'); exit;
