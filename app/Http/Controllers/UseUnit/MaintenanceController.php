<?php

namespace App\Http\Controllers\UseUnit;
use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\MaintenanceDetail;
use App\Models\MaintenanceReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index(){
        $maintenances = Maintenance::where("user_id", Auth::user()->user_id)->get();
        return view("useunit.pages.maintenance.index",compact("maintenances"));
    }

    public function maintenance($id){
        $maintenance = Maintenance::find($id);
        $review_id = $maintenance->review_id;
        $review = MaintenanceReview::find($review_id);
        $maintenanceDetails = MaintenanceDetail::with('user', 'device')->where('maintenance_id', $id)->orderBy("detail_id","desc")->get();
        return view("useunit.pages.maintenance.maintenance",compact("maintenanceDetails", 'review'));
    }

    public function detail($id){
        $detail = MaintenanceDetail::with('user', 'device')->where('detail_id', $id)->first();
        return view("useunit.pages.maintenance.detail",compact("detail"));
    }

    public function cancel($id){
        $maintenance = Maintenance::find($id);
        if($maintenance){
            $maintenance->status = 0;
            $maintenance->save();
            return response()->json(['success' => true, 'message' => 'Đã hủy phiếu bảo trì']);
        }
        return response()->json(['success'=> false, 'message'=> 'Không tìm thấy phiếu bảo trì']);
    }
}
