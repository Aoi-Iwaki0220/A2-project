<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords {
        reset as protected traitReset;
    }

    protected $redirectTo = '/home';

    public function reset(Request $request)
    {
        $request->validate([
            'mailaddress' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

       
        $request->merge(['email' => $request->input('mailaddress')]); // mailaddress を email に変換

        return $this->traitReset($request);
    }
    public function broker()
    {
        return Password::broker('parents'); // 'children' や 'users' にも変更可能
    }
}
