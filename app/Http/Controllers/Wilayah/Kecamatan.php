<?php

namespace App\Http\Controllers\Wilayah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Kecamatan extends Controller
{
    public function get_kecamatan_by_kota($id_kota = NULL)
    {
    	if($id_kota != NULL) {
    		$kecamatan = DB::table('wilayah_kecamatan')->where('id_kabkota', $id_kota)->get();
    		return response()->json([
    			'status' => TRUE,
    			'data' => ['kecamatan' => $kecamatan]
    		], 200);
    	}

    }
}
