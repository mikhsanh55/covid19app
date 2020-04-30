<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Pasien;
use App\PasienStatus;
use Validator;
class PasienController extends Controller
{
    public function __construct()
    {
        ini_set('date.timezone', 'Asia/Jayapura');
    }

    public function data()
    {
        $title = 'Data Pasien COVID-19';
        $kotakab = DB::table('wilayah_kabkota')->where('id_provinsi', 33)->get();
        $pasiens = Pasien::get_datas();
        // print_r($pasiens);exit;
        $no = 0;
        
        return view('admin/pasien/data-pasien', ['kotakab' => $kotakab, 'pasiens' => $pasiens, 'no' => $no, 'title' => $title, 'no2' => 0, 'no3' => 0, 'latest_date' => Pasien::get_latest_date()]);   
    }

    public function detail($id)
    {
        $id = Crypt::decrypt($id);
        $data = Pasien::get_detail($id);
        // print_r($data);exit;
        
        return view('admin/pasien/detail', ['datas' => $data, 'no' => 0, 'no2' => 0]);
    }
    
    public function add()
    {
        // print_r(Pasien::get_datas());exit;
        $title = 'Data Pasien COVID-19';
        $kotakab = DB::table('wilayah_kabkota')->where('id_provinsi', 33)->get();
        $pasiens = Pasien::get_datas();
        $no = 0;
        $category = ['Sembuh', 'Positif Aktif', 'Meninggal', 'Selesai ODP', 'Proses ODP', 'Selesai PDP', 'Proses PDP', 'Selesai OTG', 'Proses OTG'];
            
        return view('admin/pasien/add', ['kotakab' => $kotakab, 'pasiens' => $pasiens, 'no' => $no, 'title' => $title, 'no2' => 0, 'no3' => 0, 'latest_date' => Pasien::get_latest_date()]);
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
                
        $pasien =Pasien::get_data2($id);
        $pasien_status = PasienStatus::all(); 
        $category = ['Sembuh', 'Positif Aktif', 'Meninggal', 'Selesai ODP', 'Proses ODP', 'Selesai PDP', 'Proses PDP', 'Selesai OTG', 'Proses OTG'];
        
        for($i = 0;$i < count($category);$i++) {
            if(!isset($pasien->data[$category[$i]])) {
                $pasien->data[$category[$i]] = 0;
            }
        }

        return view('admin/pasien/edit', ['pasien' => $pasien, 'pasien_status' => $pasien_status, 'no' => 0, 'no2' => 0, 'no3' => 0]);
    }

    public function insert(Request $request)
    {
        $rules = [
            'kota' => 'required',
            'status' => 'required',
            'tgl_input' => 'required',
            'jumlah' => 'required|min:1'
        ];

        $validator = Validator::make($request->all(), $rules);

        // Simple Valdation
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data_pasiens = DB::table('pasiens as p')
                            ->where('tgl_input', $request->input('tgl_input'))
                            ->where('id_kabkota', $request->input('kota'))
                            ->where('id_pasien_status', $request->input('status'))
                            ->get();

        if($data_pasiens->count() > 0) {
            return response()->json([
                'msg' => ['Data pada tanggal ' . $request->input('tgl_input') . ' sudah ada']
            ], 400);
        }

        // Set Proses data untuk pengurangan jika memilih status 7, 8, 11
        // Pengurangan tidak jadi -- 29-04-2020

        /*  ALGORITMA INSERT DATA
        *   Sebelum diinsert, jumlahkan data sebelumnya
        *   ke data yang akan di insert sesuai dengan statusnya
        */

        // 1. Get data yang ada berdasarkan status
        $availableData = Pasien::get_data_by('id_pasien_status', $request->input('status'), $request->all());
        // 2. Jumlahkan Data yang akan diinsert dengan data yang udah di get sebelumnya sesuai status
        $requestData = $request->all();
        $jumlah = $requestData['jumlah'];
        if($availableData->count() > 0) {
            foreach($availableData as $i => $data) {
                $jumlah += $data->jumlah;
            }
        }
        $requestData['jumlah'] = $jumlah;

        // return response()->json([
        //     'status' => TRUE,
        //     'data' => $request->all()
        // ], 200);
        // 3. Insert Data
        $data = new \App\Pasien();
        $data->id_kabkota = $requestData['kota'];
        $data->id_pasien_status = $requestData['status'];
        $data->tgl_input = $requestData['tgl_input'];
        $data->jumlah = $requestData['jumlah'];            

        if($data->save()) {
            return response()->json([
                'status' => TRUE,
                'msg' => 'Data Pasien Berhasil ditambah'
            ], 200);
        }
        else {
            return response()->json([
                'status' => FALSE,
                'msg' => 'Data Pasien Gagal ditambah'
            ], 500);   
        }
        
    }

   public function update(Request $request)
   {
        // Validation
        $rules = [
            'kota' => 'required',
            'status' => 'required',
            'opsi-status' => 'required',
            'tgl_input' => 'required',
            'jumlah' => 'required|min:1'
        ];

        $validator = Validator::make($request->all(), $rules);

        // Check validation
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = Pasien::get_data2($request->input('kota'));
        $upStatus = '';
        if($request->input('opsi-status') == 1 || $request->input('opsi-status') == 3) {
            $upStatus = 'Positif Aktif';   
        }
        else if($request->input('opsi-status') == 7) {
            $upStatus = 'Proses ODP';
        }
        else if($request->input('opsi-status') == 8) {
            $upStatus = 'Proses PDP';
        }
        else if($request->input('opsi-status') == 11) {
            $upStatus = 'Proses OTG';
        }


        if(!isset($data->data[$upStatus])) {
            return response()->json([
                'status' => FALSE,
                'msg' => 'Data pasien ' . $upStatus . ' belum ada, silahkan tambahkan di Menu Tambah Pasien'
            ], 400);            
        }

       $calc = $data->data[$upStatus] - $request->input('jumlah');            
       if($calc < 0) {
            return response()->json([
                'status' => FALSE,
                'msg' => 'Jumlah input melebihi data yang ada'
            ], 400);            
       }
       else {
            // save data sembuh/meninggal
            $data = new \App\Pasien();
            $data->id_kabkota = $request->input('kota');
            $data->id_pasien_status = $request->input('opsi-status');
            $data->tgl_input = $request->input('tgl_input');
            $data->jumlah = $request->input('jumlah');
            $data->save();

            // update data positif
            $update = DB::table('pasiens')
                        ->select('*')
                        ->where('id_kabkota', $data->id_kabkota)
                        ->where('id_pasien_status', $request->input('status'))->get();
            if($this->findNumLarge($data->jumlah, $update) == false) {
                if($this->doCalc($request->input('jumlah'), $update) == true) {
                    return response()->json([
                        'status' => TRUE,
                        'msg' => 'Data Pasien Berhasil diupdate'
                    ], 200);
                } 
                else {
                    return response()->json([
                        'status' => FALSE,
                        'msg' => 'Data Pasien Gagal diupdate error:calc'
                    ], 500);
                }
            }
            else {
                return response()->json([
                    'status' => TRUE,
                    'msg' => 'Data Pasien Berhasil diupdate'
                ], 200);
            }

       }
        
    }

    public function delete(Request $request)
    {
        $id = Crypt::decrypt($request->input('id'));
        $date = $request->input('date');

        $delete = DB::table('pasiens')
                    ->where('tgl_input', $date)
                    ->where('id', $id)
                    ->delete();
        if($delete) {
            return response()->json([
                'status' => TRUE,
                'msg' => 'Data tanggal ' . $date . ' Berhasil dihapus!'
            ]);
        }   
        else {
            return response()->json([
                'status' => FALSE,
                'msg' => 'Gagal menghapus data ' . $date
            ], 500);
        }
    }
    
    // Untuk Update Data
    private function findNumLarge($jumlah, $datas) {
        for($i = 0;$i < count($datas);$i++) {
            if($datas[$i]->jumlah >= $jumlah) {
                $calc = $datas[$i]->jumlah - $jumlah;
                $pasien = Pasien::find($datas[$i]->id);
                $pasien->jumlah = $calc;
                $pasien->save();
                $i = count($datas);
                return true;
            }   
        }
        return false;
    }

    // Untuk Update data
    private function doCalc($jumlah, $datas) 
    {
        foreach ($datas as $i => $data) {
            // if jumlah greater than item in array datas
            if($data->jumlah <= $jumlah) {
                $calc = $jumlah - $data->jumlah;
                $pasien = Pasien::find($data->id);
                $pasien->jumlah = 0;
                $pasien->save();
                $jumlah = $calc;
            }
            else { // 10
                $calc = $data->jumlah - $jumlah;
                $pasien = Pasien::find($data->id);
                $pasien->jumlah = $calc;
                $pasien->save();
            }
        }
        return true;
    }

    // For filter result based date on pasien table
    public function filter_data(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $data_pasiens = Pasien::get_datas($tanggal);

        return response()->json([
            'status' => TRUE,
            'data' => $data_pasiens
        ], 200);
    }

    // For filter detail based date on detail pasien table
    public function filter_detail_data(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $id = Crypt::decrypt($request->input('_id'));
        $data_pasien = Pasien::get_detail($id, $tanggal);

        return response()->json([
            'status' => TRUE,
            'data' => $data_pasien
        ]);
    }
}