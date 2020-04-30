<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Kontak;

class KontakController extends Controller
{
    public function __construct()
    {
        ini_set('date.timezone', 'Asia/Jayapura');
    }
    
    public function index()
    {
        $datas = Kontak::all();$i = 0;
    	if($datas->count() > 0) {
            foreach($datas as $i => $data) {
                $datas[$i]['encrypt_id'] = Crypt::encrypt($data->id);
            }
        }
    	return view('admin/kontak/index', [
    		'datas' => $datas,
    		'title' => 'Kontak',
    		'no' => 0
    	]);
    }
    
    public function insert(Request $request)
    {
    	Kontak::create([
    		'nama' => $request->input('nama'),
    		'call_center' => $request->input('call_center'),
    		'hotline' => $request->input('hotline')
    	]);

    	return response()->json([
    		'status' => TRUE,
    		'msg' => 'Data Berhasil ditambah'
    	], 200);
    }

    public function detail($id) {
        $id = Crypt::decrypt($id);

        return response()->json([
            'status' => TRUE,
            'data' => Kontak::find($id)
        ], 200);
    }

    public function update(Request $request)
    {
        $id = Crypt::decrypt($request->input('_id'));
        $kontak = Kontak::find($id);
        $kontak->nama = $request->input('nama');
        $kontak->call_center = $request->input('call_center');
        $kontak->hotline = $request->input('hotline');

        $kontak->save();

        return response()->json([
            'status' => TRUE,
            '_no' => $id,
            'msg' => 'Update data berhasil'
        ]);
    }

    public function delete(Request $request)
    {
        $id = Crypt::decrypt($request->input('encrypt_id'));

        $delete = Kontak::find($id)->delete();
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