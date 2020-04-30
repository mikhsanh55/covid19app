<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function __construct()
    {
    	if(!Auth::User()) {
    		if(!Session::has('user')) {
    			Session::put('user', Auth::User());
    		}
    	}
    	else {

    	}
    
    }
}
