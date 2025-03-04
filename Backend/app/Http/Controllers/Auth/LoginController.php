<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;



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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function login(Request $request){
    //     $input =$request->all();
    //     $this->validate($request,[
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);
    //     if(auth()->attempt(array('email' => input['email'],'password' => $input['password']))){
    //         if(auth()->user()->type == 'admin'){
    //             return redirect()->route('admin.home');
    //         }else if(auth()->user()->type == 'visit'){
    //             return redirect()->route('visit.home');

    //         }else{
    //             return redirect()->route('home');
    //         }
    //     }else{
    //         return redirect()->route('login')
    //            ->with('error','Email Address and Password Are Wrong');
    //     }
    // }

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {
            if (auth()->user()->role == 'admin') {
                return redirect()->route('admin.home');
            } elseif (auth()->user()->role == 'visit') {
                return redirect()->route('user.visit');
            } else {
                return redirect()->route('admin.home');
            }
        } else {

            return redirect()->route('login')->withErrors(['email' => 'Wrong email address or password. Please try again.']);

        }
    }

}
