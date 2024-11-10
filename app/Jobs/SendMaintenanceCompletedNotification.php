<?php

namespace App\Jobs;

use App\Mail\MaintenanceCompleted;
use App\Models\Device;
use Illuminate\Bus\Queueable;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMaintenanceCompletedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reporter;
    protected $user;
    protected $detail;

    public function __construct($reporter, $user, $detail)
    {
        $this->reporter = $reporter;
        $this->user = $user;
        $this->detail = $detail;
    }

    public function handle()
    {
        $device = Device::find($this->detail->device_id);
        $message = 'Công việc bảo trì cho thiết bị ' . $device->name . ' (Số hiệu: ' . $device->code . ') đã hoàn thành.'."\n".' Kết quả công việc: ' . $this->detail->expense;
        Notification::create([
            'send_id' => $this->user->user_id,
            'receiver_id' => $this->reporter->user_id,
            'message' => $message,
            'created_at' => now(),
            'is_read' => false
        ]);
        Mail::to('vanhoa12092003@gmail.com')->send(new MaintenanceCompleted($this->reporter, $this->user, $this->detail));
    }
}
