<?php
require_once __DIR__.'/includes/auth_guard.php';
require_once __DIR__.'/classes/BookingManager.php';

$bookingManager = new BookingManager(__DIR__.'/data/bookings.json');

$id = (int)($_POST['id'] ?? 0);

if ($id > 0) {
    $bookingManager->delete($id);
}
header('Location: ./pages/dashboard.php'); exit;
