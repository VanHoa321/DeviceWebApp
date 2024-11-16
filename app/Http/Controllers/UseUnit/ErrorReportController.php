<?php

namespace App\Http\Controllers\UseUnit;

use App\Http\Controllers\Controller;
use App\Mail\ReportDevice;
use App\Models\Branch;
use App\Models\Device;
use App\Models\Buildings;
use App\Models\Room;
use App\Models\MaintenanceReview;
use App\Models\Maintenance;
use App\Models\MaintenanceDetail;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMaintenanceNotification;

class ErrorReportController extends Controller
{
    public function index()
    {
        $branchs = Branch::all();
        return view("useunit.pages.error-report.index", compact("branchs"));
    }

    public function detail(){
        return view("useunit.pages.error-report.detail");
    }

    public function addtoReport($id)
    {
        $device = Device::with('type', 'room', 'unit')->where('device_id', $id)->first();
        if ($device == null) {
            return response()->json(['danger' => true, 'message' => 'Không tìm thấy thiết bị']);
        }
        
        $reportedIssues = MaintenanceDetail::where('device_id', $device->device_id)
        ->whereIn('status', [1, 2, 3])
        ->exists();
        if ($reportedIssues) {
            return response()->json(['warning' => true, 'message' => 'Thiết bị đã được báo hỏng và đang sửa']);
        }

        $reports = session()->get('reports', []);
        if (isset($reports[$device->device_id])) {
            return response()->json(['warning' => true, 'message' => 'Thiết bị đã có trong phiếu bảo trì']);
        } else {
            $errorDescription = request()->input('error'); 
            $reports[$device->device_id] = [
                'image' => $device->image,
                'name' => $device->name,
                'type' => $device->type->name,
                'code' => $device->code,
                'unit' => $device->unit->name,
                'error' => $errorDescription,
            ];
            $selectedDevices = session()->get('selected_devices', []);
            if (!isset($selectedDevices[$device->device_id])) {
                $selectedDevices[$device->device_id] = [
                    'checked' => true,
                    'description' => $errorDescription
                ];
            }
            $count = count($reports);
            session()->put('reports', $reports);
            session()->put('selected_devices', $selectedDevices);
            return response()->json(['success' => true, 'message' => 'Thêm vào phiếu bảo trì thành công', 'count' => $count]);
        }
    }

    public function removeReport($id){
        if($id){
            $reports = session()->get('reports');
            $selectedDevices = session()->get('selected_devices', []);
            if(isset($reports[$id])){
                unset($reports[$id]);
                session()->put('reports', $reports);
            }
            $count = count($reports);
            if (isset($selectedDevices[$id])) {
                unset($selectedDevices[$id]);
                session()->put('selected_devices', $selectedDevices);
            }
            return response()->json(['success' => true, 'message' => 'Đã xóa thiết bị khỏi phiếu bảo trì', 'count' => $count]);
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy thiết bị']);
    }

    public function clearReport() {
        if (session()->has('reports')) {
            session()->forget('reports');
            return response()->json(['success' => true, 'message' => 'Đã xóa tất cả thiết bị khỏi phiếu bảo trì']);
        }
        return response()->json(['success' => false, 'message' => 'Không có thiết bị nào trong phiếu bảo trì để xóa']);
    }

    public function getReports()
    {
        $reports = session()->get('reports', []);
        return response()->json(['reports' => $reports]);
    }
    
    public function getErrorReport($id)
    {
        $reports = session()->get('reports', []);
        
        if (isset($reports[$id])) {
            return response()->json([
                'success' => true,
                'error' => $reports[$id]['error']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thiết bị trong phiếu bảo trì'
            ]);
        }
    }

    public function saveErrorReport(Request $request)
    {
        $id = $request->id;
        $error = $request->error;
        
        $reports = session()->get('reports', []);
        if (isset($reports[$id])) {
            $reports[$id]['error'] = $error;
            session()->put('reports', $reports);
            return response()->json(['success' => true, 'message' => 'Lưu mô tả lỗi thành công']);
        } else {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy thiết bị trong phiếu bảo trì']);
        }
    }

    public function saveMaintenance(Request $request){

        $reports = session()->get('reports', []);

        if (empty($reports)) {
            return response()->json([
                'error' => true,
                'message' => 'Chưa có thiết bị nào được chọn'
            ]);
        }

        foreach ($reports as $device_id => $report) {
            if (empty($report['error'])) {
                return response()->json([
                    'error' => true,
                    'message' => 'Hãy nhập mô tả lỗi cho mọi thiết bị'
                ]);
            }
        }
        
        //Tạo 1 biên bản đánh giá 
        $review = new MaintenanceReview();
        $review->quality = 5;
        $review->attitude = 5;
        $review->response = 5;
        $review->description = null;
        $review->status = 0;
        $review->save();

        $review_id = $review->review_id;

        // 2. Tạo một phiếu bảo trì mới với review_id
        $maintenance = new Maintenance();
        $maintenance->user_id = Auth::user()->user_id;
        $maintenance->created_date = now();
        $maintenance->review_id = $review_id;
        $maintenance->status = 1;
        $maintenance->description = $request->has('description') ? $request->description : null;
        $maintenance->save();

        $maintenance_id = $maintenance->maintenance_id;

        // 3. Đọc session reports và lưu vào bảng bảo trì chi tiết
        $deviceReports = [];
        $deviceList = [];
        if($reports){
            foreach ($reports as $device_id => $report) {
                $maintenanceDetail = new MaintenanceDetail();
                $maintenanceDetail->maintenance_id = $maintenance_id;
                $maintenanceDetail->user_id = Auth::user()->user_id;
                $maintenanceDetail->device_id = $device_id;
                $maintenanceDetail->status = 1;
                $maintenanceDetail->expense = null;
                $maintenanceDetail->error_description = $report['error'];
                $maintenanceDetail->save();

                $device = Device::find($device_id);
                $deviceReports[] = [
                    'image' => $device->image,
                    'name' => $device->name,
                    'code' => $device->code,
                    'error_description' => $report['error']
                ];
                $deviceList[] = ' - ' . $device->name . ' (' . $device->code . ') - Mô tả lỗi: ' . $report['error'];
            }
        }
        session()->forget('reports');
        session()->forget('selected_devices');

        //Gửi thông báo bằng job sau 10s
        $users = User::where('role_id', 3)->get();
        $sender = User::find(Auth::user()->user_id);
        $deviceListString = implode("\n", $deviceList);
        SendMaintenanceNotification::dispatch($sender, $maintenance, $deviceReports, $deviceListString)->delay(now()->addSeconds(10));
        
        return response()->json(['success' => true, 'message' => 'Tạo phiếu bảo trì thành công', 'count' => 0]);
    }

    public function getBuildingsByBranch($branch_id)
    {
        $buildings = Buildings::where('branch_id', $branch_id)->get();
        return response()->json($buildings);
    }

    public function getRoomsByBuilding($building_id)
    {
        $rooms = Room::where('building_id', $building_id)->get();
        return response()->json($rooms);
    }

    public function getDevicesByRoom(Request $request, $room_id)
    {
        $number = 3;
        $query = Device::with('type', 'room', 'unit')->where('room_id', $room_id);
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where('code', 'like', "%$search%");
        }
        $devices = $query->paginate($number);
        $selectedDevices = session()->get('selected_devices', []);
        
        return response()->json([
            'devices' => $devices,
            'selected_devices' => $selectedDevices
        ]);
    }
}
