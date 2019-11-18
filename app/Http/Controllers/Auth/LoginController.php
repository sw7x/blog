<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm()
    {
        //dd('111rrr');
        //Auth::logout();
        //dd('ddd');
        return redirect('admin');
        //return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('admin');
        //dd('wwww');
    }

    public function login(Request $request){



        $validator = Validator::make($request->all(),[
            'admin_name'         => 'required',
            'admin_pass'         => 'required'
            ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }else{
            //dd('fff');

            if(Auth::attempt([
                'name' => $request->input('admin_name'),
                'password' => $request->input('admin_pass')
            ])){
                //dd('login success');
                return redirect()->route('admin.dashboard');
            }

            //dd('failed');
            return redirect()->back()->with('message','Authentication failed');
            //->route('admin.index');
            //return view('admin.index');
            //return back();
        }




    }

}
