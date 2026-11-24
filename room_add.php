<?php
require_once __DIR__.'/includes/auth_guard.php';
require_once __DIR__.'/classes/RoomManager.php';
require_once __DIR__.'/classes/Room.php';

$roomManager = new RoomManager(__DIR__.'/data/rooms.json');

$name = trim($_POST['name'] ?? '');
$capacity = trim($_POST['capacity'] ?? '');
$tv = trim($_POST['tv'] ?? '');
$stereo = trim($_POST['stereo'] ?? 'ostartad');

if ($name && $capacity && $tv && $stereo) {
    $room = new Room($roomManager->nextId(), $name, $capacity, $tv, $stereo);
    $roomManager->add($room);
}
header('Location: /pages/allrooms.php'); exit;
