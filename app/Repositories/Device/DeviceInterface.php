<?php

namespace App\Repositories\Device;

interface DeviceInterface {
    public function all();
    public function find($id);
    public function store($data);
    public function update($id, $data);
    public function delete($id);
}