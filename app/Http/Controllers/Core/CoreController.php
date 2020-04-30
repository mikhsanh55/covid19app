<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoreController extends Controller
{
	public function __construct()
	{
		ini_set('date.timezone', 'Asia/Jayapura');
	}
}