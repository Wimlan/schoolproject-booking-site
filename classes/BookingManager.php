<?php
require_once __DIR__.'/JsonFile.php';
require_once __DIR__.'/Booking.php';

class BookingManager {
    private JsonFile $store;

    public function __construct(string $filePath) {
        $this->store = new JsonFile($filePath);
    }

    public function isBooked(int $roomId, string $day, string $timeSlot): bool {
        return $this->bookedBy($roomId, $day, $timeSlot) !== null;
    }

    public function bookedBy(int $roomId, string $day, string $timeSlot): ?int {
        foreach ($this->store->read() as $booking) {
            if (
                isset($booking['room_id'], $booking['day'], $booking['timeslot'], $booking['bookedBy'])
                && $booking['room_id'] === $roomId
                && $booking['day'] === $day
                && $booking['timeslot'] === $timeSlot
            ) {
                return $booking['bookedBy'];
            }
        }
        return null;
    }

    public function bookingsByRoom(int $roomId): array {
        $roomBookings = [];
        foreach ($this->store->read() as $booking) {
            if (isset($booking['room_id']) && $booking['room_id'] === $roomId) {
                $roomBookings[] = $booking;
            }
        }
        return $roomBookings;
    }

        public function add(Booking $booking): void {
        $bookings = $this->store->read();
        $bookings[] = ['id'=>$booking->id, 'room_id'=>$booking->room_id, 'day'=>$booking->day, 'timeslot'=>$booking->timeslot, 'bookedBy'=>$booking->bookedBy];
        $this->store->write($bookings);
    }
}
