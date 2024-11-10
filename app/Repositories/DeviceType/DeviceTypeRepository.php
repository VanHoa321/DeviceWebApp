<?php

namespace App\Repositories\DeviceType;
use App\Models\DeviceType;

class DeviceTypeRepository implements DeviceTypeInterface {
    protected $dtype;

    public function __construct(DeviceType $dtype){
        $this->dtype = $dtype;
    }

    public function all() {
        return $this->dtype::orderBy('type_id', 'desc')->get();
    }

    public function find($id) {
        return $this->dtype->find($id);
    }

    public function store($data) {
        return $this->dtype->create($data);
    }

    public function update($id, $data) {
        $dtype = $this->dtype->find($id);
        if($dtype){
            $dtype->update($data);
        }
    }

    public function delete($id) {
        $dtype = $this->dtype->find($id);
        if($dtype){
            $dtype->delete();
            return true;
        }
        return false;
    }
}