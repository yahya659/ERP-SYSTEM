<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    //
    public function index(){
        return redirect()->route('admin.login');
    }
    public function show_login_view(){
        // اذا المستخدمم مسجل دخول لايستطيع الااعاده الى الراوت التسجيل لاذا عمل تسجيل خروج
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
    }else{
        return view('admin.auth.login');
    }

    }
    public function login(LoginRequest $request){
        if(auth()->guard('admin')->attempt(['username'=>$request->input('username'),'password'=>$request->input('password')]))
            {

$adminName = auth()->guard('admin')->user()->name;

return redirect()
    ->route('admin.dashboard')
    ->with('success', 'تم تسجيل الدخول بنجاح-- يا ' . $adminName);            }

            else{
                return redirect()->route('login')->with('eror','الااسم او الرمز غير صحيح');
            }
    }
// تسجيل الخروج
  public function logout()
{
    $adminName = auth()->guard('admin')->user()->name;

    auth()->guard('admin')->logout();

    return redirect()
        ->route('login')
        ->with('logout', 'تم تسجيل الخروج بنجاح يا ' . $adminName . ' — نحن في انتظار عودتك');
}

}
