<?php
    $pageTitle   = 'Dashboard';
    $pageHeading = 'Uppgifter';
require_once __DIR__.'/../includes/auth_guard.php';
require_once __DIR__.'/../includes/header.php';
require_once __DIR__.'/../classes/RoomManager.php';
require_once __DIR__.'/../classes/BookingManager.php';
$roomManager = new RoomManager(__DIR__.'/../data/rooms.json');
$bookingManager = new BookingManager(__DIR__.'/../data/bookings.json');


$rooms = $roomManager->all();
$details = false;
$filter = $_GET['filter'] ?? 'all';
$day = $_GET['day'] ?? '';
$timeSlot = $_GET['timeSlot'] ?? '';
if ($filter === 'free' && $day !== '' && $timeSlot !== '') {
    $availableRooms = [];
    foreach ($rooms as $room) {
        if (!$bookingManager->isBooked((int)$room['id'], $day, $timeSlot)) {
            $availableRooms[] = $room;
        }
    }
    $rooms = $availableRooms;
}

?>

<h1>Boka ett rum</h1>

<div class="new-room-form ">
<h2>Lägg till ett nytt rum</h2>
<form class="flex-row" action="/room_add.php" method="post">
    <div class="flex-column">
    <label for="name">Namn:</label>
    <input type="text" id="name" name="name" required>

    <label for="capacity">Antal platser:</label>
    <input type="text" id="capacity" name="capacity" required>
    <button type="submit">Skapa</button>
    </div>

    <div class="flex-column">
    <label for="tv">TV:</label>
    <select id="tv" name="tv">
        <option value="1">Ja</option>
        <option value="0">Nej</option>
    </select>

    <label for="stereo">Stereo:</label>
    <select id="stereo" name="stereo">
        <option value="1">Ja</option>
        <option value="0">Nej</option>
    </select>
    </div>
  <br>

</form>
</div>

<h2>Filtrera efter lediga rum</h2>
<form method="get">
       <input type="hidden" name="filter" value="free">
    <label for="day">Dag:</label>
    <select id="day" name="day">
        <option value="">Välj dag</option>
        <option value="Måndag" <?= $day === 'Måndag' ? 'selected' : '' ?>>Måndag</option>
        <option value="Tisdag" <?= $day === 'Tisdag' ? 'selected' : '' ?>>Tisdag</option>
        <option value="Onsdag" <?= $day === 'Onsdag' ? 'selected' : '' ?>>Onsdag</option>
        <option value="Torsdag" <?= $day === 'Torsdag' ? 'selected' : '' ?>>Torsdag</option>
        <option value="Fredag" <?= $day === 'Fredag' ? 'selected' : '' ?>>Fredag</option>
    </select>
    <label for="timeSlot">Tid:</label>
    <select id="timeSlot" name="timeSlot">
        <option value="">Välj tid</option>
        <option value="08:00-10:00" <?= $timeSlot === '08:00-10:00' ? 'selected' : '' ?>>08:00-10:00</option>
        <option value="10:00-12:00" <?= $timeSlot === '10:00-12:00' ? 'selected' : '' ?>>10:00-12:00</option>
        <option value="12:00-14:00" <?= $timeSlot === '12:00-14:00' ? 'selected' : '' ?>>12:00-14:00</option>
        <option value="14:00-16:00" <?= $timeSlot === '14:00-16:00' ? 'selected' : '' ?>>14:00-16:00</option>
    </select>
    <button type="submit">Filtrera rum</button>
    <button type="submit" name="filter" value="all">Visa alla rum</button>
</form>

<ul>
    <?php foreach ($rooms as $room): ?>
          <h3><?= htmlspecialchars($room['name']) ?></h3>
          <ul>
<li>Antal platser: <?= htmlspecialchars($room['capacity']) ?></li>
<li>TV: <?= $room['tv'] ? 'Ja' : 'Nej' ?></li>
<li>Stereo: <?= $room['stereo'] ? 'Ja' : 'Nej' ?></li>
          </ul>
          <a class="button" href="booking.php?room=<?= (int)$room['id'] ?>">Boka nu</a>
        <?php endforeach; ?>
</ul>



<?php require_once __DIR__.'/../includes/footer.php'; ?>
