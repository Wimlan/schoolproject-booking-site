<?php
require_once __DIR__.'/includes/auth_guard.php';
require_once __DIR__.'/classes/BookingManager.php';
require_once __DIR__.'/classes/Booking.php';

$bookingManager = new BookingManager(__DIR__.'/data/bookings.json');

$day = trim($_POST['day'] ?? '');
$timeslot = trim($_POST['timeslot'] ?? '');
$room_id = trim($_POST['room_id'] ?? '');
$roomId = (int)$room_id;
$bookedBy = $user['id'];

if($day && $timeslot && $room_id && $bookedBy){
    if($bookingManager->isBooked($roomId, $day, $timeslot)) {
       header('Location: /pages/booking.php?room='.urlencode($room_id)); exit;
    }
    $booking = new Booking($bookingManager->nextId(), $day, $timeslot, $roomId, $bookedBy);
    $bookingManager->add($booking);
}

header('Location: /pages/booking.php?room='.urlencode($room_id)); exit;
