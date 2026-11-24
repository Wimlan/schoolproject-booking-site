<?php
    $pageTitle   = 'Dashboard';
    $pageHeading = 'Uppgifter';
require_once __DIR__.'/../includes/auth_guard.php';
require_once __DIR__.'/../includes/header.php';
require_once __DIR__.'/../classes/RoomManager.php';
require_once __DIR__.'/../classes/BookingManager.php';
require_once __DIR__.'/../classes/UserManager.php';
$roomManager = new RoomManager(__DIR__.'/../data/rooms.json');
$bookingManager = new BookingManager(__DIR__.'/../data/bookings.json');
$userManager = new UserManager(__DIR__.'/../data/users.json');
$rooms = $roomManager->all();
$bookings = $bookingManager->all();
?>

<ul>
    <?php foreach ($bookings as $booking): ?>
        <?php if ($booking['bookedBy'] === $user['id']): ?>
          <h3><?= htmlspecialchars($roomManager->findById($booking['room_id'])['name']) ?></h3>
          <ul>
            <li>Dag: <?= htmlspecialchars($booking['day']) ?></li>
            <li>Tid: <?= htmlspecialchars($booking['timeslot']) ?></li>
          </ul>
          <div class="flex-row">
          <a class="button" href="booking.php?room=<?= (int)$booking['room_id'] ?>">Se detaljer</a>
            <form action="/booking_delete.php" method="post">
        <input type="hidden" name="id" value="<?= $booking['id'] ?>">
        <button type="submit">Ta bort</button>
        </div>
      </form>
        <?php endif; ?>
        <?php endforeach; ?>
</ul>


<?php require_once __DIR__.'/../includes/footer.php'; ?>
