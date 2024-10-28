<?php

namespace App\Repositories\Building;
use App\Models\Buildings;

class BuildingRepository implements BuildingInterface {
    protected $building;

    public function __construct(Buildings $building){
        $this->building = $building;
    }

    public function all() {
        return $this->building::with('branch')->get();
    }

    public function find($id) {
        return $this->building->find($id);
    }

    public function store($data) {
        return $this->building->create($data);
    }

    public function update($id, $data) {
        $buildings = $this->building->find($id);
        if($buildings){
            $buildings->update($data);
        }
    }

    public function delete($id) {
        $building = $this->building->find($id);
        if($building){
            $building->delete();
            return true;
        }
        return false;
    }
}