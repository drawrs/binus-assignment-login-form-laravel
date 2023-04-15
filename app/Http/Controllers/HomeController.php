<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function myCaptcha()
    {
        return view('myCaptcha');
    }

    public function myCaptchaPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);

        // Handle login logic here

        return redirect()->back()->with('success', 'Captcha validation passed!');
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    public function resetPassword()
    {
        $token = "";
        return view('reset-password')->with(compact('token'));
    }

    public function postResetPassword(Request $request) {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $user_id = Auth::id();
        $user = \App\User::find($user_id);

        $new_password = $request->password;
        $user->password = bcrypt($new_password);

        
        if ($user->save()) {
            $message = "Password changed!";
        } else {
            $message = "Failed to update password.";
        }

        return redirect()->back()->with(compact('message'));
    }

}
