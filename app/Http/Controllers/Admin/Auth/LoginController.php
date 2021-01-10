<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Admin;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if ($this->attemptLogin($request)) {
            if (Auth::guard('admin')->check()) {
                Admin::where('id', Auth::guard('admin')->user()->id)->update(['last_login' => Carbon::now()]);
                return redirect()->intended('/admin/dashboard');
            }
        }

        return redirect()->back()->withErrors(['errors' => 'Invalid username or password.'])->withInput($request->except('password'));
    }

    private function attemptLogin(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if ($admin) {
            if (Hash::check($request->password, $admin->password)) {
                return Auth::guard('admin')->attempt([
                    'email' => $request->email,
                    'password' => $request->password,
                ]);
            }
        }

        return false;
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
