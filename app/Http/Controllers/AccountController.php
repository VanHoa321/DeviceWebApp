<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WorkUnit;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function login(){
        return view("login");
    }

    public function postLogin(Request $request) {
        $user = User::where('user_name', $request->user_name)->first();
        if ($user) {
            if (is_null($user->email_verified_at)) {
                $request->session()->put("messenge", ["style" => "danger", "msg" => "Tài khoản chưa được xác minh"]);
                return redirect()->route("login");
            }
            if ($user->status == 0) {
                $request->session()->put("messenge", ["style" => "danger", "msg" => "Tài khoản của bạn đã bị khóa"]);
                return redirect()->route("login");
            }
    
            if (Auth::attempt(["user_name" => $request->user_name, "password" => $request->password, "role_id" => 1])) {
                $request->session()->put("messenge", ["style" => "success", "msg" => "Đăng nhập quyền quản trị thành công"]);
                return redirect()->route("home.index");
            }
            elseif (Auth::attempt(["user_name" => $request->user_name, "password" => $request->password, "role_id" => 2])) {
                $request->session()->put("messenge", ["style" => "success", "msg" => "Đăng nhập quyền đơn vị sử dụng thành công"]);
                return redirect()->route("homeU.index");
            }
            elseif (Auth::attempt(["user_name" => $request->user_name, "password" => $request->password, "role_id" => 3])) {
                $request->session()->put("messenge", ["style" => "success", "msg" => "Đăng nhập quyền bộ phận phụ trách thành công"]);
                return redirect()->route("homeM.index");
            }
            elseif (Auth::attempt(["user_name" => $request->user_name, "password" => $request->password, "role_id" => 4])) {
                $request->session()->put("messenge", ["style" => "success", "msg" => "Đăng nhập quyền kỹ thuật viên thành công"]);
                return redirect()->route("homeT.index");
            } 
        }
        $request->session()->put("messenge", ["style" => "danger", "msg" => "Thông tin tài khoản không đúng"]);
        return redirect()->route("login");
    }    

    public function logout(){
        Auth::logout();
        return redirect()->route("login");
    }

    public function profile(){
        $user = Auth::user();
        $position = Position::where("position_id",$user->position_id)->first();
        $unit = WorkUnit::where("unit_id",$user->unit_id)->first();
        $role = Role::where("role_id",$user->role_id)->first();
        return view('my-account.profile', compact('user','unit', 'role', 'position'));
    }
    
    public function editProfile(){
        $user = Auth::user();
        $unit = WorkUnit::where("unit_id",$user->unit_id)->first();
        $position = Position::where("position_id",$user->position_id)->first();
        return view('my-account.edit_profile', compact('user','unit','position'));
    }

    public function updateProfile(Request $request){
        $oldUser = Auth::user();
        $id = $oldUser->user_id;
        $update = User::find($id);
        $update->full_name = $request->full_name;
        $update->email = $request->email;
        $update->phone = $request->phone;
        $update->address = $request->address;
        $update->dob = $request->dob;
        $update->avatar = $request->avatar;
        $update->save();
        $request->session()->put("messenge", ["style" => "success", "msg" => "Cập nhật hồ sơ thành công"]);
        return redirect()->route('profile');
    }

    public function editPassword(){
        $user = Auth::user();
        return view('my-account.edit_password', compact('user'));
    }

    public function updatePassword(Request $request){
        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            $request->session()->put("messenge", ["style" => "danger", "msg" => "Mật khẩu cũ không đúng"]);
            return redirect()->back();
        }
        $id = $user->user_id;
        $update = User::find($id);
        $update->password = Hash::make($request->new_password);
        $update->save();
        $request->session()->put("messenge", ["style" => "success", "msg" => "Cập nhật mật khẩu thành công"]);
        return redirect()->route('profile');
    }

    public function verify($email){
        $acc = User::where('email', $email)->whereNull('email_verified_at');
        if ($acc) {
            $acc->update([
                'email_verified_at' => date('Y-m-d'),
                'status' => 1
            ]);
            return redirect()->route("login");
        }
    }
}
