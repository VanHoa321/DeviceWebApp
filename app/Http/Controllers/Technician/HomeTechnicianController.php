<?php

namespace App\Http\Controllers\Technician;
use App\Http\Controllers\Controller;
use App\Models\MaintenanceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeTechnicianController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $timeType = $request->get('timeType', 'all');
            $startDate = $request->get('startDate', null);
            $endDate = $request->get('endDate', null);

            // Lấy báo cáo hỏng theo phân loại thiết bị
            $failureByCategory = MaintenanceDetail::select('device_types.name as category_name', DB::raw('COUNT(maintenance_details.device_id) as failure_count'))
                ->join('devices', 'maintenance_details.device_id', '=', 'devices.device_id')
                ->join('device_types', 'devices.type_id', '=', 'device_types.type_id')
                ->join('maintenances', 'maintenance_details.maintenance_id', '=', 'maintenances.maintenance_id')
                ->where('maintenance_details.user_id', Auth::user()->user_id)
                ->where('maintenance_details.status', 4);

            // Lọc theo thời gian nếu có
            if ($startDate && $endDate) {
                $failureByCategory->whereBetween('maintenances.created_date', [$startDate, $endDate]);
            } elseif ($timeType !== 'all') {
                $now = Carbon::now();
                if ($timeType == 'filterDay') {
                    $failureByCategory->whereDate('maintenances.created_date', $now->toDateString());
                } elseif ($timeType == 'filterWeek') {
                    $failureByCategory->whereBetween('maintenances.created_date', [
                        $now->startOfWeek()->toDateString(),
                        $now->endOfWeek()->toDateString(),
                    ]);
                } elseif ($timeType == 'filterMonth') {
                    $failureByCategory->whereMonth('maintenances.created_date', $now->month);
                } elseif ($timeType == 'filterYear') {
                    $failureByCategory->whereYear('maintenances.created_date', $now->year);
                }
            }
    
            $failureByCategory = $failureByCategory->groupBy('device_types.name')
                ->orderByDesc('failure_count')
                ->take(5)
                ->get();
    
            // Lấy báo cáo hỏng theo phòng
            $topRoomsByFailures = MaintenanceDetail::select('rooms.name as room_name', DB::raw('COUNT(maintenance_details.device_id) as failure_count'))
                ->join('devices', 'maintenance_details.device_id', '=', 'devices.device_id')
                ->join('rooms', 'devices.room_id', '=', 'rooms.room_id')
                ->join('maintenances', 'maintenance_details.maintenance_id', '=', 'maintenances.maintenance_id')
                ->where('maintenance_details.user_id', Auth::user()->user_id)
                ->where('maintenance_details.status', 4);
    
            // Lọc theo thời gian nếu có
            if ($startDate && $endDate) {
                $topRoomsByFailures->whereBetween('maintenances.created_date', [$startDate, $endDate]);
            } elseif ($timeType !== 'all') {
                $now = Carbon::now();
                if ($timeType == 'filterDay') {
                    $topRoomsByFailures->whereDate('maintenances.created_date', $now->toDateString());
                } elseif ($timeType == 'filterWeek') {
                    $topRoomsByFailures->whereBetween('maintenances.created_date', [
                        $now->startOfWeek()->toDateString(),
                        $now->endOfWeek()->toDateString(),
                    ]);
                } elseif ($timeType == 'filterMonth') {
                    $topRoomsByFailures->whereMonth('maintenances.created_date', $now->month);
                } elseif ($timeType == 'filterYear') {
                    $topRoomsByFailures->whereYear('maintenances.created_date', $now->year);
                }
            }
    
            $topRoomsByFailures = $topRoomsByFailures->groupBy('rooms.name')
                ->orderByDesc('failure_count')
                ->take(5)
                ->get();
    
            return response()->json([
                'failureByCategory' => $failureByCategory,
                'topRoomsByFailures' => $topRoomsByFailures
            ]);
        }
        $taskWait = MaintenanceDetail::where('user_id', Auth::user()->user_id)->where('status', 3)->get()->count();
        $taskComplete = MaintenanceDetail::where('user_id', Auth::user()->user_id)->where('status', 4)->get()->count();
        $deviceCount = MaintenanceDetail::where('user_id', Auth::user()->user_id)
            ->where('status', 4)
            ->distinct('device_id')
            ->count('device_id');
        return view("technician.pages.home.index", compact('taskWait', 'taskComplete', 'deviceCount'));
    }
    
    public function taskWait(){
        $tasks = MaintenanceDetail::with('user', 'device', 'maintenance')->where('user_id', Auth::user()->user_id)->where('status', 3)->orderBy('detail_id', 'desc')->get();
        return view("technician.pages.home.task_wait", compact("tasks"));
    }

    public function taskComplete(){
        $tasks = MaintenanceDetail::with('user', 'device', 'maintenance')->where('user_id', Auth::user()->user_id)->where('status', 4)->orderBy('detail_id', 'desc')->get();
        return view("technician.pages.home.task_complete", compact("tasks"));
    }
}
