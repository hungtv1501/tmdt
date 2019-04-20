<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\CheckingAdminLoginPost as AdminLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admins as AdminModel;

class LoginController extends Controller
{
    public function loginView(Request $request)
    {
    	$mes = $request->session()->get('error');
    	// $messages = $_GET['error'] ?? '';
    	return view('Admin.login.login_view')->with('error',$mes);
    }

    public function handleLogin(AdminLogin $request, AdminModel $admin)
    {
    	// thực hiên validation form
    	// dd($request->all());
    	$username = $request->username;
    	$username = trim(strip_tags($username));

    	$password = $request->password;
    	$password = trim(strip_tags($password));

    	$infoData = $admin->checkAdminLogin($username, $password);
    	// dd($infoData);
    	if (isset($infoData['id']) && isset($infoData['username'])) {
    		// luu thong tin cua nguoi dung vao session
    		$request->session()->put('id',$infoData['id']);
    		$request->session()->put('user',$infoData['username']);
    		$request->session()->put('email',$infoData['email']);
    		$request->session()->put('role',$infoData['role']);

    		// cho vao trang dashboard admin
    		return redirect()->route('admin.dashboard');
    	}
    	else {
    		// luu loi vao sesstion
    		// quay ve lai dung trang login
    		$request->session()->flash('error','Tên đăng nhập hoặc mật khẩu sai');
    		return redirect()->route('admin.loginView');
    	}
    }

    public function logout(Request $request)
    {
    	// xoa session
    	$request->session()->forget('id');
    	$request->session()->forget('user');
    	$request->session()->forget('email');
    	$request->session()->forget('role');
    	return redirect()->route('admin.loginView');
    }
}