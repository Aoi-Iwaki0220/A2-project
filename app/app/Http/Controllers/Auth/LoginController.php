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

    protected function authenticated(Request $request, $user)
    {
    // user_typeをセッションに記録（parent or child）
        session(['user_type' => $request->input('user_type')]);

        return redirect('/home');
    }

    public function logout(Request $request)  //ログアウトしたらログアウト前のURLを消す→HOMEに
    {
        Auth::guard(session('user_type'))->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('url.intended');

        return redirect('/login');
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
