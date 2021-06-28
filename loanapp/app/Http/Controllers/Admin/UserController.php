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
use Illuminate\Support\Str;

class UserController extends Controller
{
	public function index(){
		$users = User::orderBy('id','DESC')->where('user_role',1)->get();
		return view('pages.admin.users.index')->with([ 'users' => $users ]);
	}

	public function create(){
		return view('pages.admin.users.create');
	}

	public function save(Request $request){
		$rules = array(
			'name' => 'required',
			'email' => 'required|unique:users',
			'phone' => 'required|unique:users'
		);
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
			return redirect()->back()->withErrors($validator);
		}

		$profile_image = '';

		if( $request->hasFile('profile_image') ){
			$image = $request->file('profile_image');
	        $profile_image = time().'.'.$image->getClientOriginalExtension();
	        $destinationPath = public_path('/profile_images');
	        $image->move($destinationPath, $profile_image);
		}

		$password = Hash::make(str_random(32));
		$users = new User();
		$users->name = $request->name;
		$users->email = $request->email;
		$users->password = $password;
		$users->phone = $request->phone;
		$users->address = $request->address;
		$users->city = $request->city;
		$users->state = $request->state;
		$users->country = $request->country;
		$users->zip = $request->zip;
		$users->lat = $request->lat;
		$users->lon = $request->lon;
		$users->profile_image = $profile_image;
		$users->save();

		return redirect()->back()->with('success','User Added successfully');

	}

	public function edit($id){
		$user = User::find($id);
		return view('pages.admin.users.edit')->with([ 'user' => $user ]);
	}

	public function update(Request $request , $id){
		$rules = array(
			'name' => 'required',
			'email' => 'required|unique:users,email,'.$id,
			'phone' => 'required|unique:users,phone,'.$id
		);
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
			return redirect()->back()->withErrors($validator);
		}

		$users = User::find($id);

		if( $request->hasFile('profile_image') ){
			$image = $request->file('profile_image');
	        $profile_image = time().'.'.$image->getClientOriginalExtension();
	        $destinationPath = public_path('/profile_images');
	        $image->move($destinationPath, $profile_image);
	        $users->profile_image = $profile_image;
		}

		
		$users->name = $request->name;
		$users->email = $request->email;
		$users->phone = $request->phone;
		$users->address = $request->address;
		$users->city = $request->city;
		$users->state = $request->state;
		$users->country = $request->country;
		$users->zip = $request->zip;
		$users->lat = $request->lat;
		$users->lon = $request->lon;
		$users->save();

		return redirect()->back()->with('message','User Updated successfully');
	}

	public function delete(Request $request , $id){
		$delete_user = User::find($id);
		$delete_user->delete();
		return redirect('admin/users')->with('message','User Deleted successfully');
	}
}