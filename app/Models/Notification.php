<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        "send_id",
        "receiver_id", 
        "message",
        "created_at",
        "is_read"
    ];
    protected $primaryKey = 'id';
    protected $table = 'notifications';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'send_id');
    }
}
