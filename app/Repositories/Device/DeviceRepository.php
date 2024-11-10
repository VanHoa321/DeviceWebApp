<?php

namespace App\Repositories\Device;
use App\Models\Device;

class DeviceRepository implements DeviceInterface {
    protected $device;

    public function __construct(Device $device) {
        $this->device = $device;
    }

    public function all() {
        return $this->device::with('type', 'room', 'unit')->orderBy('device_id', 'desc')->get();
    }

    public function find($id) {
        return $this->device->find($id);
    }

    public function store($data) {
        return $this->device->create($data);
    }

    public function update($id, $data) {
        $device = $this->device->find($id);
        if ($device) {
            $device->update($data);
            return $device;
        }
        return null;
    }

    public function delete($id) {
        $device = $this->device->find($id);
        if ($device) {
            $device->delete();
            return true;
        }
        return false;
    }
}
