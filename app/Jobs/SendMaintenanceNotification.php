<?php

namespace App\Jobs;

use App\Mail\ReportDevice;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMaintenanceNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sender;
    protected $maintenance;
    protected $deviceReports;
    protected $deviceListString;

    public function __construct($sender, $maintenance, $deviceReports, $deviceListString)
    {
        $this->sender = $sender;
        $this->maintenance = $maintenance;
        $this->deviceReports = $deviceReports;
        $this->deviceListString = $deviceListString;
    }

    public function handle()
    {
        $users = User::where('role_id', 3)->get();
        $message = 'Có một đơn bảo trì mới từ ' . $this->sender->full_name . ' chờ được xác nhận. Danh sách thiết bị bao gồm:' . "\n" . $this->deviceListString;
        $created_at = now();

        foreach ($users as $user) {
            Notification::create([
                'send_id' => $this->sender->user_id,
                'receiver_id' => $user->user_id,
                'message' => $message,
                'created_at' => $created_at,
                'is_read' => false
            ]);
            Mail::to('vanhoa12092003@gmail.com')->send(new ReportDevice($this->sender, $this->maintenance, $this->deviceReports));
        }
    }
}
