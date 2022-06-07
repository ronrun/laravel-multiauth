<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
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

    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        // Attemp to log the user in
        if(Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)){
            // If successful, then redirect to their intended location
            return redirect()->intended(route('admin.dashboard'));
        }

        // If unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('username', 'remember'));

    }

    /*
    public function authenticated (Request $request)
    {
        $previous_url = Session::get('_previous.url');

        $folder_admin = env('FOLDER_ADMIN');

        $pattern = "#^(http|https)(://[^/]+/)([^/]+)#";
        preg_match($pattern, $previous_url, $matches);
        if($matches[3] != $folder_admin){
            return redirect($folder_admin);
        }
    }
	*/

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        if (Auth::guard('web')->check() && Auth::guard('admin')->check()){
            $request->session()->invalidate();
        }
        
        return redirect(route('admin.login'));
    }

    //這個再看看是否必要
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
