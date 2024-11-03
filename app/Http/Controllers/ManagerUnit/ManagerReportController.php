<?php

namespace App\Http\Controllers\ManagerUnit;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\MaintenanceDetail;
use App\Models\User;
use Illuminate\Http\Request;

class ManagerReportController extends Controller
{
    public function index(){
        $list = Maintenance::orderBy('maintenance_id','desc')->get();
        return view("manager-unit.pages.maintenance.index",compact('list'));
    }

    public function maintenance_detail($id){
        $maintenance = Maintenance::find($id);
        $maintenanceDetails = MaintenanceDetail::with('user', 'device')->where('maintenance_id', $id)->orderBy("detail_id","desc")->get();
        $users = User::with('role', 'position', 'unit')->where('role_id', 4)->where('status', 1)->whereNotNull('email_verified_at')->orderBy('user_id', 'desc')->get();
        return view("manager-unit.pages.maintenance.maintenance",compact("maintenanceDetails", "users"));
    }

    public function detail($id){
        $detail = MaintenanceDetail::with('user', 'device')->where('detail_id', $id)->first();
        $main_id = $detail->maintenance_id;
        return view("manager-unit.pages.maintenance.detail",compact("detail", "main_id"));
    }

    public function confirm($id){
        $maintenance = Maintenance::find($id);
        if($maintenance){
            $maintenance->status = 2;
            $maintenance->save();
            $maintenanceDetails = MaintenanceDetail::where('maintenance_id', $maintenance->maintenance_id)->get();
            foreach ($maintenanceDetails as $detail) {
                $detail->status = 2;
                $detail->save();
            }
            return response()->json(['success'=> true, 'message'=> 'Duyệt phiếu bảo trì thành công']);
        }
        return response()->json(['success'=> false, 'message'=> 'Không tìm thấy phiếu bảo trì']);
    }

    public function assignTechnician(Request $request)
    {
        $detailId = $request->detail_id;
        $userId = $request->user_id;

        $maintenanceDetail = MaintenanceDetail::find($detailId);
        if ($maintenanceDetail) {
            $maintenanceDetail->user_id = $userId;
            $maintenanceDetail->status = 3;
            $maintenanceDetail->save();

            return response()->json(['success' => true, 'message' => 'Phân công kỹ thuật viên thành công']);
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy chi tiết bảo trì']);
    }
}
