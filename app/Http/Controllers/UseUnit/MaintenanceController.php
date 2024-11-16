<?php

namespace App\Http\Controllers\UseUnit;
use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\MaintenanceDetail;
use App\Models\MaintenanceReview;
use App\Models\MaintenanceFile;
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
        return view("useunit.pages.maintenance.maintenance",compact("maintenanceDetails", 'review', 'maintenance'));
    }

    public function detail($id){
        $detail = MaintenanceDetail::with('user', 'device')->where('detail_id', $id)->first();
        $main_id = $detail->maintenance_id;
        $files = MaintenanceFile::where('detail_id', $detail->detail_id)->get();
        return view("useunit.pages.maintenance.detail",compact("detail", "main_id", "files"));
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

    public function saveReview(Request $request)
    {
        $review = MaintenanceReview::where('review_id', $request->review_id)->first();
        if ($review) {
            $review->quality = $request->quality;
            $review->attitude = $request->attitude;
            $review->response = $request->response;
            $review->description = $request->description;
            $review->status = 1;
            $review->save();
            return response()->json(['success' => true, 'message' => 'Đánh giá công việc thành công']);
        }else{
            return response()->json(['success' => false, 'message' => 'Đánh giá công việc thất bại']);
        }
    }
}
