<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    protected function redirectTo(){
        $userType = session('user_type');

        switch ($userType) {
            case 'admin':
                return '/management';
            case 'parent':
                return '/home';
            case 'child':
                return '/home';
            default:
                return '/home';
        }
    }

     protected function validateLogin(Request $request)
    {
        $request->validate([
            'mailaddress' => ['required', 'email', 'max:50'],
            'password' => ['required', 'string'],
            'user_type' => ['required', 'in:parent,child,admin'],
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $login = $request->only('mailaddress', 'password');//$requestからメアドとパスワードのみ取り出す
        $guard = $request->input('user_type');//user_type取得

        if (!in_array($guard, ['parent', 'child','admin'])) {//user_typeが'parent'か'child'でなければfalseをかえす
            return false;
        }

        return auth()->guard($guard)->attempt($login, $request->filled('remember'));
    }

    protected function authenticated(Request $request, $user)
    {
    // ログイン時のuser_typeをセッションに保存
    $userType = $request->input('user_type');
    session(['user_type' => $userType]);
    }

    public function logout(Request $request)
    {
        $guard = session('user_type');

        if ($guard && in_array($guard, ['parent', 'child', 'admin'])) {
            Auth::guard($guard)->logout();
        }
        $request->session()->forget('user_type');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth:parent,child,admin')->only('logout');
    }


}
