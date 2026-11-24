<?php
    $pageTitle   = 'Dashboard';
    $pageHeading = 'Uppgifter';
require_once __DIR__.'/../includes/auth_guard.php';
require_once __DIR__.'/../includes/header.php';
require_once __DIR__.'/../classes/RoomManager.php';
require_once __DIR__.'/../classes/BookingManager.php';
$takenicon = '../assets/img/taken.png';
$bookedicon = '../assets/img/booked.png';
$roomManager = new RoomManager(__DIR__.'/../data/rooms.json');
$bookingManager = new BookingManager(__DIR__.'/../data/bookings.json');
$userManager = new UserManager(__DIR__.'/../data/users.json');
$roomId = (int)($_GET['room'] ?? 0);
$room = $roomManager->findById($roomId);

$days = ['Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag'];
$timeSlots = ['08:00-10:00', '10:00-12:00', '12:00-14:00', '14:00-16:00'];
$bookdialog = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['open_booking'])) {
    $requestedDay = $_POST['day'] ?? '';
    $requestedTimeSlot = $_POST['timeslot'] ?? '';
    $bookdialog = true;

}
?>

<?php if(!$room): ?>
    <p>Room not found.</p>
    <?php exit; ?>
<?php endif; ?>

<h1><?= htmlspecialchars($room['name']) ?></h1>
<p>Rum kapacitet: <?= htmlspecialchars($room['capacity']) ?></p>
<p>TV: <?= $room['tv'] ? 'Ja' : 'Nej' ?></p>
<p>Stereo: <?= $room['stereo'] ? 'Ja' : 'Nej' ?></p>

<h2>Boka rum</h2>
<table class="booking-table">
  <thead>
    <tr>
        <th scope="col"></th>
        <?php foreach ($days as $day): ?>
            <th scope="col"><?= htmlspecialchars($day) ?></th>
        <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($timeSlots as $timeSlot): ?>
        <tr>
            <th scope="row"><?= htmlspecialchars($timeSlot) ?></th>
            <?php foreach ($days as $day):
                $bookedBy = $bookingManager->bookedBy($roomId, $day, $timeSlot);
                $bookedbyother = $bookedBy !== null && $bookedBy !== $user['id'];
                $bookedbyme = $bookedBy !== null && $bookedBy === $user['id'];
                $bookingOwner = $bookedBy !== null ? $userManager->findById($bookedBy) : null;
                ?>
                <td>
                    <?php if ($bookedbyother): ?>
                        <img width="15" height="15" src="<?= $takenicon ?>" alt=""><p>Bokad av <?= htmlspecialchars($bookingOwner['username']) ?></p>
                    <?php elseif ($bookedbyme): ?>
                        <img width="15" height="15" src="<?= $bookedicon ?>" alt=""><p>Bokad</p>
                    <?php else: ?>
                        <form method="post">
                            <input type="hidden" name="day" value="<?= htmlspecialchars($day) ?>">
                            <input type="hidden" name="timeslot" value="<?= htmlspecialchars($timeSlot) ?>">
                            <button type="submit" name="open_booking" value="1">Boka</button>
                        </form>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php if ($bookdialog): ?>
<dialog open>
    <form>
        <p>Boka rum <?= htmlspecialchars($room['name']) ?> på <?= htmlspecialchars($requestedDay) ?> <?= htmlspecialchars($requestedTimeSlot) ?></p>
        <button type="submit">Boka</button>
        <a href="/pages/booking.php?room=<?= htmlspecialchars($roomId) ?>" type="button">Avbryt</a>
    </form>
</dialog>
<?php endif; ?>



<?php require_once __DIR__.'/../includes/footer.php'; ?>
