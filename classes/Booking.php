<?php
class Booking {
    public function __construct(
        public int $id,
        public string $day,
        public string $timeslot,
        public int $room_id,
        public ?int $bookedBy
    ) {}
}
