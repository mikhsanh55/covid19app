<?php

namespace App\Http\Controllers\Wilayah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Kelurahan extends Controller
{
    public function get_kelurahan_by_kecamatan($id_kecamatan = NULL)
    {
    	if($id_kecamatan != NULL){
    		$kelurahan = DB::table('wilayah_kelurahan')->where('id_kecamatan', $id_kecamatan)->get();
    		return response()->json([
    			'status' => TRUE,
    			'data' => ['kelurahan' => $kelurahan]
    		], 200);
    	}
    }
}
