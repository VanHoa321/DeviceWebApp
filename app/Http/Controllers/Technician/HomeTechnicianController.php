<?php

namespace App\Http\Controllers\Technician;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HomeTechnicianController extends Controller
{
    public function index(){
        return view("technician.pages.home.index");
    } 
}
