<?php

namespace App\Http\Controllers\ManagerUnit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeManagerUnitController extends Controller
{
    public function index(){
        return view("manager-unit.pages.home.index");
    }
}
