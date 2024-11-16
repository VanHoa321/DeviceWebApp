<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buildings;
use App\Models\Device;
use App\Models\MaintenanceDetail;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $timeType = $request->get('timeType', 'all');
            $startDate = $request->get('startDate', null);
            $endDate = $request->get('endDate', null);

            $topDeviceReport = MaintenanceDetail::select('devices.name', DB::raw('COUNT(maintenance_details.device_id) as failure_count'))
                ->join('devices', 'maintenance_details.device_id', '=', 'devices.device_id')
                ->join('maintenances', 'maintenance_details.maintenance_id', '=', 'maintenances.maintenance_id')
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
    
            $topDeviceReport = $topDeviceReport->groupBy('devices.name')
                ->orderByDesc('failure_count')
                ->take(5)
                ->get();
    
            // Lấy báo cáo hỏng theo phân loại thiết bị
            $failureByCategory = MaintenanceDetail::select('device_types.name as category_name', DB::raw('COUNT(maintenance_details.device_id) as failure_count'))
                ->join('devices', 'maintenance_details.device_id', '=', 'devices.device_id')
                ->join('device_types', 'devices.type_id', '=', 'device_types.type_id')
                ->join('maintenances', 'maintenance_details.maintenance_id', '=', 'maintenances.maintenance_id')
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
                'failureByCategory' => $failureByCategory,
                'topRoomsByFailures' => $topRoomsByFailures
            ]);
        }

        $userCount = User::count();
        $deviceCount = Device::count();
        $buildingCount = Buildings::count();
        $roomCount = Room::count();
        $topDeviceReport = MaintenanceDetail::select(
            'devices.device_id',
            'devices.name',
            'devices.image',
            'devices.code',
            DB::raw('COUNT(maintenance_details.device_id) as failure_count')
        )
            ->join('devices', 'maintenance_details.device_id', '=', 'devices.device_id')
            ->where('maintenance_details.status', 4)
            ->groupBy('devices.device_id', 'devices.name', 'devices.image', 'devices.code')
            ->orderByDesc('failure_count')
            ->get();
        return view("admin.pages.home.index", compact('userCount', 'deviceCount', 'buildingCount', 'roomCount', 'topDeviceReport'));
    }
}
