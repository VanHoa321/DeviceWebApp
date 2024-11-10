<?php

namespace App\Jobs;

use App\Mail\TechnicianAssigned;
use App\Models\Device;
use Illuminate\Bus\Queueable;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTechnicianAssignmentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reporter;
    protected $taskmaster;
    protected $detail;
    protected $maintenance;
    protected $userid;

    public function __construct($reporter, $taskmaster, $detail, $maintenance, $userid)
    {
        $this->reporter = $reporter;
        $this->taskmaster = $taskmaster;
        $this->detail = $detail;
        $this->maintenance = $maintenance;
        $this->userid = $userid;
    }

    public function handle()
    {
        
        $device = Device::find($this->detail->device_id);
        $message = 'Bạn vừa được phân công bảo trì cho thiết bị ' . $device->name . ' với số hiệu ' . $device->code . "\n" . ' Báo cáo lỗi của thiết bị:' . $this->detail->error_description;
        $created_at = now();
        Notification::create([
            'send_id' => $this->reporter->user_id,
            'receiver_id' => $this->userid,
            'message' => $message,
            'created_at' => $created_at,
            'is_read' => false
        ]);
        Mail::to('vanhoa12092003@gmail.com')->send(new TechnicianAssigned($this->reporter, $this->taskmaster, $this->maintenance, $this->detail));
    }
}

