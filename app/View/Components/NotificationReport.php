<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationReport extends Component
{
    public $listNoti;
    public $count;
    public function __construct()
    {
        $this->listNoti = Notification::where('is_read', false)->where('receiver_id', Auth::user()->user_id)->orderBy('id', 'desc')->take(3)->get();
        $this->count = Notification::where('is_read', false)->where('receiver_id', Auth::user()->user_id)->count();
    }

    public function render(): View|Closure|string
    {
        return view('components.notification-report');
    }
}
