<?php

namespace App\Repositories\Room;
use App\Models\Room;

class RoomRepository implements RoomInterface {
    protected $room;

    public function __construct(Room $room) {
        $this->room = $room;
    }

    public function all() {
        return $this->room::with('building')->orderBy('room_id', 'desc')->get();
    }

    public function find($id) {
        return $this->room->find($id);
    }

    public function store($data) {
        return $this->room->create($data);
    }

    public function update($id, $data) {
        $room = $this->room->find($id);
        if ($room) {
            $room->update($data);
            return $room;
        }
        return null;
    }

    public function delete($id) {
        $room = $this->room->find($id);
        if ($room) {
            $room->delete();
            return true;
        }
        return false;
    }
}
