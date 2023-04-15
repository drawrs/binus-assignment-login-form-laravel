<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CapthaController extends Controller
{
    //
    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}
