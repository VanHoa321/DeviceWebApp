<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceFile extends Model
{
    use HasFactory;

    protected $fillable = [
        "detail_id",
        "file_path"
    ];
    protected $primaryKey = 'file_id';
    protected $table = 'maintenance_files';
    public $timestamps = false;
}
