<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

     protected function validateLogin(Request $request)
    {
        $request->validate([
            'mailaddress' => ['required', 'email', 'max:50'],
            'password' => ['required', 'string'],
            'user_type' => ['required', 'in:parent,child'],
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $login = $request->only('mailaddress', 'password');//$requestからメアドとパスワードのみ取り出す
        $guard = $request->input('user_type');//user_type取得

        if (!in_array($guard, ['parent', 'child'])) {//user_typeが'parent'か'child'でなければfalseをかえす
            return false;
        }

        // user_typeに応じたガードで認証
        return auth()->guard($guard)->attempt($login, $request->filled('remember'));
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function redirectTo() {
        return '/home';
    }
    
}
