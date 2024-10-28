<?php

namespace App\Repositories\Branch;
use App\Models\Branch;

class BranchRepository implements BranchInterface {
    protected $branch;

    public function __construct(Branch $branch){
        $this->branch = $branch;
    }

    public function all() {
        return $this->branch::orderBy('branch_id', 'desc')->get();
    }
}