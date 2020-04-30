<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\User;
class UserController extends Controller
{
    public function __construct()
    {
        ini_set('date.timezone', 'Asia/Jayapura');
    }
    public function index()
    {
    	// $users = DB::table('tb_users')->get(); -> Manual
    	$users = User::all();
    	return view('user/index', [
    		'no' => 0,
    		'users' => $users
    	]);
    }

    public function edit($id)
    {
    	// $user = DB::table('tb_users')->where('id', $id)->first(); -> Manual
    	$user = User::find($id);

    	return view('user/edit', ['user' => $user]);
    }

    public function insert(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required',
    		'password' => 'required'
    	]);

    	// Eloquent
    	User::create([
    		'email' => $request->input('email'),
    		'password' => password_hash($request->input('password'), PASSWORD_DEFAULT)
    	]);
    	// DB::table('tb_users')->insert([
    		// 'email' => $request->input('email'),
    		// 'password' => password_hash($request->input('password'), PASSWORD_DEFAULT)
    	// ]);

    	return redirect('/user');
    }

    public function update(Request $request)
    {
    	// DB::table('tb_users')->where('id', $request->input('id'))->update([
    	// 	'email' => $request->input('email'),
    	// 	'password' => password_hash($request->input('password'), PASSWORD_DEFAULT)
    	// ]);
    	$this->validate($request, [
    		'email' => 'required',
    		'password' => 'required'
    	]);

    	$user = User::find($request->input('id'));
    	$user->email = $request->input('email');
    	$user->password = $request->input('password');
    	$user->save();

    	return redirect('/user');
    }

    public function hapus($id)
    {
    	// DB::table('tb_users')->where('id', $id)->delete();
    	$user = User::find($id);
    	$user->delete();
    	return redirect('/user');
    }
}
