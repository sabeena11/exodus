<?php

namespace App\Http\Controllers\Auth;

use App\Models\CompanySetting;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Helper\HashPassword;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $setting = CompanySetting::first();
        return view('auth.login', compact('setting'));
    }

    protected function redirectTo()
    {
        return 'admin/dashboard';
    }

    public function login(Request $request)
    {

// Define the country code prefix
$countryCode = '+977';

// Check if the mobile number already includes the country code prefix
if (substr($request->mobile, 0, strlen($countryCode)) == $countryCode) {
    $mobile = $request->mobile;
} else {
    $mobile = $countryCode . $request->mobile;
}

        // $password1 = hash_hmac('sha256', '+977'.$request->mobile.$request->password, env('JWT_SECRET'));

        $userPassword = User::where(['mobile' => $mobile])->first();

        if (!$userPassword == null) {
            $password1 = HashPassword::verify($request->password, $userPassword->password);

            if ($password1) {
                // $user = User::where(['mobile' => '+977'.$request->mobile, 'password' => $password1, 'is_staff' => 1, 'is_verified' => 1])->first();

                $password1 = $userPassword->password;

                $user = User::where(['mobile' => $mobile, 'password' => $password1, 'is_staff' => 1, 'is_verified' => 1])->first();

                if (!$user == null)
                {
                    if (Auth::loginUsingId($user->id))
                    {
                        $user->last_login = now();
                        $user->save();
                        return $this->sendLoginResponse($request);
                    }
                    else
                    {
                        return $this->sendFailedLoginResponse($request, 'auth.failed_status');
                    }
                } else {
                    return $this->sendFailedLoginResponse($request, 'auth.failed_status');
                }
            } else {
                return $this->sendFailedLoginResponse($request, 'auth.failed_status');
            }
        } else {
            return $this->sendFailedLoginResponse($request, 'auth.failed_status');
        }
    }




    public function username()
    {
        return 'mobile';
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect(route('login'));
    }
}
