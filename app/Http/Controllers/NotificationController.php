<?php

namespace App\Http\Controllers;
use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        $noti = Notification::where('receiver_id', Auth::user()->user_id)->orderBy('id', 'desc')->get();
        return view('notification.index', compact('noti'));
    }

    public function detail($id){
        $noti = Notification::find($id);
        $noti->is_read = 1;
        $noti->save();
        return view('notification.detail', compact('noti'));
    }

    public function destroy($id)
    {
        $destroy = Notification::find($id);
        if ($destroy) {
            $destroy->delete();
            return response()->json(['success' => true, 'message' => 'Xóa thông báo thành công']);
        } else {
            return response()->json(['danger' => false, 'message' => 'Xóa thông báo không thành công'], 404);
        }
    }
}
