<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\RumahSakit;
class RumahSakitController extends Controller
{
    public function __construct()
    {
        ini_set('date.timezone', 'Asia/Jayapura');
    }
    public function index()
    {
    	$datas = RumahSakit::where('rujukan', '1')->get();
    	$i = 0;
    	if($datas->count() > 0) {
    		foreach($datas as $i => $data) {
	    		$datas[$i]['encrypt_id'] = Crypt::encrypt($data->id);
	    	}
    	}
    	return view('admin/rumah_sakit/index', [
    		'datas' => $datas,
    		'title' => 'Data Rumah Sakit Rujukan',
    		'no' => 0
    	]);
    }

    public function rumah_sakit()
    {
    	$datas = RumahSakit::where('rujukan', '0')->get();
    	$i = 0;
    	if($datas->count() > 0) {
    		foreach($datas as $i => $data) {
	    		$datas[$i]['encrypt_id'] = Crypt::encrypt($data->id);
	    	}
    	}

    	return view('admin/rumah_sakit/rumah-sakit', [
    		'datas' => $datas,
    		'title' => 'Data Rumah Sakit',
    		'no' => 0
    	]);
    }

    public function insert(Request $request)
    {
    	RumahSakit::create([
    		'nama' => $request->input('nama'),
    		'alamat' => $request->input('alamat'),
    		'no' => $request->input('no'),
    		'ket' => $request->input('ket'),
    		'rujukan' => $request->input('rujukan'),
    	]);

    	return response()->json([
    		'status' => TRUE,
    		'msg' => 'Data Berhasil ditambah'
    	], 200);
    }

    public function detail($encrypt_id)
    {
    	$id = Crypt::decrypt($encrypt_id);

    	$data = RumahSakit::find($id);
    	return response()->json([
    		'status' => TRUE,
    		'data' => $data
    	], 200);
    }

    public function update(Request $request)
    {
    	$id = Crypt::decrypt($request->input('_id'));
    	$rumah_sakit = RumahSakit::find($id);
    	$rumah_sakit->nama = $request->input('nama');
    	$rumah_sakit->alamat = $request->input('alamat');
    	$rumah_sakit->no = $request->input('no');
    	$rumah_sakit->ket = $request->input('ket');
    	$rumah_sakit->rujukan = $request->input('rujukan');

    	$rumah_sakit->save();

    	return response()->json([
    		'status' => TRUE,
    		'msg' => 'Update data berhasil'
    	]);
    }

    public function delete(Request $request)
    {
    	$id = Crypt::decrypt($request->input('encrypt_id'));

    	$delete = RumahSakit::find($id)->delete();
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
