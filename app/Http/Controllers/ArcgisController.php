<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arcgis;
use Illuminate\Support\Facades\Crypt;

class ArcgisController extends Controller
{
    public function index()
    {
    	$data = Arcgis::firstRecord();
    	$data->encrypt_id = Crypt::encrypt($data->id);
    	$title = 'Peta Arcgis' ;

    	return view('arcgis/index', ['data' => $data, 'title' => $title]);
    }

    public function update(Request $request) 
    {
    	$id = Crypt::decrypt($request->input('_id'));
    	$updated = Arcgis::find($id);
    	$updated->src = $request->input('arcgis_src');
    	if($updated->save()) {
    		return response()->json([
    			'status' => TRUE
    		], 200);
		}
		else {
			return response()->json([
    			'status' => FALSE
    		], 500);	
		}
    }
}
