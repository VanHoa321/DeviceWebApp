<?php

namespace App\Http\Controllers\UseUnit;
use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\MaintenanceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeUserUnitController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $timeType = $request->get('timeType', 'all');
            $startDate = $request->get('startDate', null);
            $endDate = $request->get('endDate', null);

            $topDeviceReport = MaintenanceDetail::select('devices.name', DB::raw('COUNT(maintenance_details.device_id) as failure_count'))
                ->join('devices', 'maintenance_details.device_id', '=', 'devices.device_id')
                ->join('maintenances', 'maintenance_details.maintenance_id', '=', 'maintenances.maintenance_id')
                ->where('maintenances.user_id', Auth::user()->user_id)
                ->where('maintenance_details.status', 4);

            // Lọc theo thời gian nếu có
            if ($startDate && $endDate) {
                $topDeviceReport->whereBetween('maintenances.created_date', [$startDate, $endDate]);
            } elseif ($timeType !== 'all') {
                $now = Carbon::now();
                if ($timeType == 'filterDay') {
                    $topDeviceReport->whereDate('maintenances.created_date', $now->toDateString());
                } elseif ($timeType == 'filterWeek') {
                    $topDeviceReport->whereBetween('maintenances.created_date', [
                        $now->startOfWeek()->toDateString(),
                        $now->endOfWeek()->toDateString(),
                    ]);
                } elseif ($timeType == 'filterMonth') {
                    $topDeviceReport->whereMonth('maintenances.created_date', $now->month);
                } elseif ($timeType == 'filterYear') {
                    $topDeviceReport->whereYear('maintenances.created_date', $now->year);
                }
            }
    
            $topDeviceReport = $topDeviceReport->groupBy('devices.name')->orderByDesc('failure_count')->take(5)->get();

            $maintenanceStatus = Maintenance::select(
        DB::raw("COUNT(CASE WHEN status = 0 THEN 1 END) as canceled_count"),
                DB::raw("COUNT(CASE WHEN status = 1 THEN 1 END) as pending_count"),
                DB::raw("COUNT(CASE WHEN status = 2 THEN 1 END) as in_progress_count"),
                DB::raw("COUNT(CASE WHEN status = 3 THEN 1 END) as completed_count")
            )
            ->where('user_id', Auth::user()->user_id);
            //Lọc theo thời gian nếu có
            if ($startDate && $endDate) {
                $maintenanceStatus->whereBetween('maintenances.created_date', [$startDate, $endDate]);
            } elseif ($timeType !== 'all') {
                $now = Carbon::now();
                if ($timeType == 'filterDay') {
                    $maintenanceStatus->whereDate('maintenances.created_date', $now->toDateString());
                } elseif ($timeType == 'filterWeek') {
                    $maintenanceStatus->whereBetween('maintenances.created_date', [
                        $now->startOfWeek()->toDateString(),
                        $now->endOfWeek()->toDateString(),
                    ]);
                } elseif ($timeType == 'filterMonth') {
                    $maintenanceStatus->whereMonth('maintenances.created_date', $now->month);
                } elseif ($timeType == 'filterYear') {
                    $maintenanceStatus->whereYear('maintenances.created_date', $now->year);
                }
            }
            $maintenanceStatus = $maintenanceStatus->first();

            $topRoomsByFailures = MaintenanceDetail::select('rooms.name as room_name', DB::raw('COUNT(maintenance_details.device_id) as failure_count'))
            ->join('devices', 'maintenance_details.device_id', '=', 'devices.device_id')
            ->join('rooms', 'devices.room_id', '=', 'rooms.room_id')
            ->join('maintenances', 'maintenance_details.maintenance_id', '=', 'maintenances.maintenance_id')
            ->where('maintenances.user_id', Auth::user()->user_id)
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
                'topDeviceReport' => $topDeviceReport,
                'maintenanceStatus' => [
                    ['name' => 'Đã hủy', 'failure_count' => $maintenanceStatus->canceled_count],
                    ['name' => 'Chờ xác nhận', 'failure_count' => $maintenanceStatus->pending_count],
                    ['name' => 'Đang bảo trì', 'failure_count' => $maintenanceStatus->in_progress_count],
                    ['name' => 'Đã hoàn thành', 'failure_count' => $maintenanceStatus->completed_count],
                ],
                'topRoomsByFailures' => $topRoomsByFailures
            ]);
        }
        $maintenanceCount = Maintenance::where('user_id', Auth::user()->user_id)->where('status', '!=', 0)->count();
        $deviceCount = MaintenanceDetail::join('maintenances', 'maintenance_details.maintenance_id', '=', 'maintenances.maintenance_id')
            ->where('maintenances.user_id', Auth::user()->user_id)
            ->where('maintenances.status', '!=', 0)
            ->distinct('maintenance_details.device_id')
            ->count('maintenance_details.device_id');
        $completeCount = Maintenance::where('user_id', Auth::user()->user_id)->where('status', 3)->count();
        $topDeviceReport = MaintenanceDetail::select(
            'devices.device_id',
            'devices.name',
            'devices.image',
            'devices.code',
            DB::raw('COUNT(maintenance_details.device_id) as failure_count')
        )
            ->join('devices', 'maintenance_details.device_id', '=', 'devices.device_id')
            ->join('maintenances', 'maintenance_details.maintenance_id', '=', 'maintenances.maintenance_id')
            ->where('maintenance_details.status', 4)
            ->where('maintenances.user_id', Auth::user()->user_id)
            ->groupBy('devices.device_id', 'devices.name', 'devices.image', 'devices.code')
            ->orderByDesc('failure_count')
            ->get();
        return view("useunit.pages.home.index", compact("maintenanceCount", "deviceCount", "completeCount", "topDeviceReport"));
    }
}
