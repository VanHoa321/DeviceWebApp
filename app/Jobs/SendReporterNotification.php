<?php

namespace App\Jobs;

use App\Mail\SendReport;
use App\Mail\SendReportNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Device;
use App\Models\Notification;

class SendReporterNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $technician;
    protected $taskmaster;
    protected $detail;
    protected $maintenance;
    protected $userid;
    public function __construct($technician, $taskmaster, $detail, $maintenance, $userid)
    {
        $this->technician = $technician;
        $this->taskmaster = $taskmaster;
        $this->detail = $detail;
        $this->maintenance = $maintenance;
        $this->userid = $userid;
    }

    public function handle(): void
    {
        $device = Device::find($this->detail->device_id);
        $message = 'Thiết bị mà bạn báo hỏng ' . $device->name . ' với số hiệu ' . $device->code . "\n" . ' Đã được phân công cho kỹ thuật viên:' . $this->technician->full_name . 'và có số điện thoại là: '. $this->technician->phone;
        $created_at = now();
        Notification::create([
            'send_id' => $this->taskmaster->user_id,
            'receiver_id' => $this->userid,
            'message' => $message,
            'created_at' => $created_at,
            'is_read' => false
        ]);
        Mail::to('vanhoa12092003@gmail.com')->send(new SendReport($this->technician, $this->taskmaster, $this->maintenance, $this->detail));
    }
}
