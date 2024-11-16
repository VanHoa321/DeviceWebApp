<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Maintenance;
use App\Models\MaintenanceDetail;
use App\Models\MaintenanceFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendMaintenanceCompletedNotification;

class TaskController extends Controller
{
    public function index(){
        $tasks = MaintenanceDetail::with('user', 'device', 'maintenance')->where('user_id', Auth::user()->user_id)->orderBy('detail_id', 'desc')->get();
        return view("technician.pages.task.index", compact("tasks"));
    }

    public function detail($id){
        $detail = MaintenanceDetail::with('user', 'device')->where('detail_id', $id)->first();
        $maintenance = Maintenance::where('maintenance_id', $detail->maintenance_id)->first();
        $sender = User::find($maintenance->user_id);
        $files = MaintenanceFile::where('detail_id', $detail->detail_id)->get();
        return view("technician.pages.task.detail",compact("detail", "sender", "files"));
    }

    public function updateTask(Request $request)
    {
        try {
            $urls = $request->json('urls');
            $result = $request->json('result');
            $detail_id = $request->json('detail_id');
            if (empty($urls)) {
                return response()->json(['error' => 'No URLs provided'], 400);
            }
            $detail = MaintenanceDetail::find($detail_id);
            $detail->status = 4;
            $detail->expense = $result;
            $detail->save();
            foreach ($urls as $url) {
                $create = new MaintenanceFile();
                $create->detail_id = $detail_id;
                $create->file_path = $url;
                $create->save();
            }
            $device = Device::find($detail->device_id);
            $device->status = 1;
            $device->save();
            $maintenance_id = $detail->maintenance_id;
            $remainingDetails = MaintenanceDetail::where('maintenance_id', $maintenance_id)
                ->where('status', '!=', 4)
                ->exists();

            if (!$remainingDetails) {
                $maintenance = Maintenance::find($maintenance_id);
                $maintenance->status = 3;
                $maintenance->save();
            }
            $maintenance = Maintenance::where('maintenance_id', $detail->maintenance_id)->first();
            $reporter = User::where('user_id', $maintenance->user_id)->first();
            $user = User::where('user_id', Auth::user()->user_id)->first();
            SendMaintenanceCompletedNotification::dispatch($reporter, $user, $detail)->delay(now()->addSeconds(10));
            return response()->json(['success' => 'URLs received successfully', 'data' => $urls]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function cancelTask($id){
        $detail = MaintenanceDetail::find($id);
        if ($detail){
            $detail->status = 0;
            $detail->save();
            return response()->json(['success' => true, 'message' => 'Hủy công việc thành công']);
        } else {
            return response()->json(['danger' => false, 'message' => 'Có lỗi xảy ra, hãy thử lại sau'], 404);
        }

    }
}
