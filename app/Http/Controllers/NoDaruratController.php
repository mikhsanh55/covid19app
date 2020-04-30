<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\NoDarurat;
class NoDaruratController extends Controller
{
    public function __construct()
    {
        ini_set('date.timezone', 'Asia/Jayapura');
    }
    public function index()
    {
    	$datas = NoDarurat::all();$i = 0;
    	if($datas->count() > 0) {
            foreach($datas as $i => $data) {
                $datas[$i]['encrypt_id'] = Crypt::encrypt($data->id);
            }
        }
    	return view('admin/no_darurat/index', [
    		'datas' => $datas,
    		'title' => 'Nomor Darurat',
    		'no' => 0
    	]);
    }

    public function insert(Request $request)
    {
    	NoDarurat::create([
    		'call_center' => $request->input('call_center'),
    		'no_diskes' => $request->input('no_diskes')
    	]);

    	return response()->json([
    		'status' => TRUE,
    		'msg' => 'Data Berhasil ditambah'
    	], 200);
    }

    public function detail($encrypt_id)
    {
    	$id = Crypt::decrypt($encrypt_id);

    	$data = NoDarurat::find($id);
    	return response()->json([
    		'status' => TRUE,
    		'data' => $data
    	], 200);
    }

    public function update(Request $request)
    {
    	$id = Crypt::decrypt($request->input('_no'));
    	$no_darurat = NoDarurat::find($id);
    	$no_darurat->call_center = $request->input('call_center');
    	$no_darurat->no_diskes = $request->input('no_diskes');

    	$no_darurat->save();

    	return response()->json([
    		'status' => TRUE,
    		'_no' => $id,
    		'msg' => 'Update data berhasil'
    	]);
    }

    public function delete(Request $request)
    {
    	$id = Crypt::decrypt($request->input('encrypt_id'));

    	$delete = NoDarurat::find($id)->delete();
    	if($delete) {
    		return response()->json([
	    		'status' => TRUE,
	    		'msg' => 'Data berhasil dihapus'
	    	]);
    	}

    	return response()->json([
    		'status' => FALSE,
    		'msg' => 'Something Wrong'
    	], 500);
    }
}
