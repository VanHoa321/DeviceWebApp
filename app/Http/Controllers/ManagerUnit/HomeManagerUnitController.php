<?php

namespace App\Http\Controllers\ManagerUnit;
use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class HomeManagerUnitController extends Controller
{
    public function index(){
        $confirmCount = Maintenance::where('status', 1)->orderBy('maintenance_id','desc')->count();
        $progressCount = Maintenance::where('status', 2)->orderBy('maintenance_id','desc')->count();
        $successCount = Maintenance::where('status', 3)->orderBy('maintenance_id','desc')->count();
        $cancelCount = Maintenance::where('status', 0)->orderBy('maintenance_id','desc')->count();
        return view("manager-unit.pages.home.index", compact('confirmCount', 'progressCount', 'successCount', 'cancelCount'));
    }

    public function listConfirm(){
        $list = Maintenance::where('status', 1)->orderBy('maintenance_id','desc')->get();
        return view("manager-unit.pages.maintenance.index",compact('list'));
    }

    public function listProgress(){
        $list = Maintenance::where('status', 2)->orderBy('maintenance_id','desc')->get();
        return view("manager-unit.pages.maintenance.index",compact('list'));
    }

    public function listSuccess(){
        $list = Maintenance::where('status', 3)->orderBy('maintenance_id','desc')->get();
        return view("manager-unit.pages.maintenance.index",compact('list'));
    }

    public function listCancel(){
        $list = Maintenance::where('status', 0)->orderBy('maintenance_id','desc')->get();
        return view("manager-unit.pages.maintenance.index",compact('list'));
    }
}
