<?php
require_once __DIR__.'/JsonFile.php';
require_once __DIR__.'/Room.php';

class RoomManager {
    private JsonFile $store;

    public function __construct(string $filePath) {
        $this->store = new JsonFile($filePath);
    }

    public function all(): array { return $this->store->read(); }

    public function findByName(string $name): ?array {
        foreach ($this->all() as $r) {
            if (strcasecmp($r['name'], $name) === 0) return $r;
        }
        return null;
    }

    public function findById(int $id): ?array {
        foreach ($this->all() as $r) { if ($r['id'] === $id) return $r; }
        return null;
    }

    public function nextId(): int {
        $max = 0; foreach ($this->all() as $r) { if ($r['id'] > $max) $max = $r['id']; }
        return $max + 1;
    }

       public function add(Room $room): void {
        $rooms = $this->all();
        $rooms[] = ['id'=>$room->id, 'name'=>$room->name, 'capacity'=>$room->capacity, 'tv'=>$room->tv, 'stereo'=>$room->stereo];
        $this->store->write($rooms);
    }

}
