<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Roles;
use Auth;
use Toastr;

class AuthController extends Controller
{
    public function register_auth(){
        return view('admin.custom_auth.register');
    }
    public function login_auth(){
        return view('admin.custom_auth.login_auth');
    }
    public function logout_auth(){
        Auth::logout();
        Toastr::success('Đăng xuất auth thành công','Thành công');
        return redirect('/logout-auth');
    }
    public function login(Request $request){
        $this->validate($request,[
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|max:255',
        ]);
        // $data = $request->all();
        if(Auth::attempt(['admin_email'=>$request->admin_email, 'admin_password'=>$request->admin_password])){
            Toastr::success('Đăng nhập auth thành công','Thành công');
            return redirect('/dashboard');
        }else{
            Toastr::error('Lỗi đăng nhập','Thất bại');
            return redirect('/login-auth');
        }
    }
    public function register(Request $request){
        $this->validation($request);
        $data = $request->all();

        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_password = md5($data['admin_password']);
        $admin->save();
        Toastr::success('Đăng ký auth thành công','Thành công');
        return redirect('/register-auth');
    }
    public function validation($request){
        return $this->validate($request,[
            'admin_name' => 'required|max:255',
            'admin_phone' => 'required|max:255',
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|max:255',
        ]);
    }
    
}
