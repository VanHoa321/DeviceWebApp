<?php

namespace App\Repositories\WorkUnit;
use App\Models\WorkUnit;

class WorkUnitRepository implements WorkUnitInterface {
    protected $unit;

    public function __construct(WorkUnit $unit) {
        $this->unit = $unit;
    }

    public function all() {
        return $this->unit::orderBy('unit_id', 'desc')->get();
    }
}
