<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use DB;
use Carbon\Carbon;

class AdminController extends Controller
{
	public function dashboard(Request $request){

		$users_count = User::count();
		return View('pages.admin.dashboard')->with([ 'users_count' , $users_count ]);        
	}

	public function login(){
		return view('home-admin.login');
	}

	public function loginUser(Request $request){
		$validator = Validator::make ( $request->all (), [ 
			'email' => 'required|email',
			'password' => 'required']
		);
		if ($validator->fails ()) {
			return redirect('/')->withErrors($validator)->withInput();
		}

		$credentials = $request->only('email', 'password');
		if (Auth::attempt($credentials)) {
			// dd(Auth::attempt($credentials));
			return redirect('/admin/dashboard');
		}
		return redirect('/admin/login');
	}

	public function logout(Request $request){
		Auth::logout();
        return redirect()->intended('/admin/login');
	}

}