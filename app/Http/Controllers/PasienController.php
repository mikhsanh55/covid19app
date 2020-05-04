<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Pasien;
use App\PasienStatus;
use App\RumahSakit;
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

        // Make requeted data writeable
        $requestData = $request->all();
        $status = $requestData['status'];

        // Validation
        if($request->input('status') == 1 || $request->input('status') == 3) {
            $parentData = Pasien::get_latest_data_by(2, $request->all());
            if($parentData->count() > 0) {
                $insertedParentData = new \App\Pasien();
                $insertedParentData->id_kabkota = $requestData['kota'];
                $insertedParentData->id_pasien_status = 2;
                $insertedParentData->tgl_input = $requestData['tgl_input'];
                $insertedParentData->jumlah = 0;      
                $insertedParentData->sum_jumlah = $parentData[0]->sum_jumlah;
                $insertedParentData->save();    
            }
            else {
                $this->sendError(['Data Positif Aktif belum ada, harap inputkan terlebih dahulu'], 400);
            }
            
        }
        else if($request->input('status') == 7) { // Selesai ODP
            $parentData = Pasien::get_latest_data_by(4, $request->all());
            if($parentData->count() > 0) {
                // Insert parent data
                $insertedParentData = new \App\Pasien();
                $insertedParentData->id_kabkota = $requestData['kota'];
                $insertedParentData->id_pasien_status = 4;
                $insertedParentData->tgl_input = $requestData['tgl_input'];
                $insertedParentData->jumlah = 0;      
                $insertedParentData->sum_jumlah = $parentData[0]->sum_jumlah;
                $insertedParentData->save();
            }
            else {
                $this->sendError(['Data ODP Proses belum ada, harap inputkan terlebih dahulu'], 400);
            }
                
        }

        else if($request->input('status') == 8) { // Selesai PDP
            $parentData = Pasien::get_latest_data_by(5, $request->all());

            if($parentData->count() > 0) {
                // Insert parent data
                $insertedParentData = new \App\Pasien();
                $insertedParentData->id_kabkota = $requestData['kota'];
                $insertedParentData->id_pasien_status = 5;
                $insertedParentData->tgl_input = $requestData['tgl_input'];
                $insertedParentData->jumlah = 0;      
                $insertedParentData->sum_jumlah = $parentData[0]->sum_jumlah;
                $insertedParentData->save();
            }
            else {
                $this->sendError(['Data PDP Proses belum ada, harap inputkan terlebih dahulu'], 400);    
            }
        }
        else if($request->input('status') == 11) { // Selesai ODP
            $parentData = Pasien::get_latest_data_by(6, $request->all());

            if($parentData->count() > 0) {
                // Insert parent data
                $insertedParentData = new \App\Pasien();
                $insertedParentData->id_kabkota = $requestData['kota'];
                $insertedParentData->id_pasien_status = 6;
                $insertedParentData->tgl_input = $requestData['tgl_input'];
                $insertedParentData->jumlah = 0;      
                $insertedParentData->sum_jumlah = $parentData[0]->sum_jumlah;
                $insertedParentData->save();
            }
            else {
                $this->sendError(['Data OTG Proses belum ada, harap inputkan terlebih dahulu'], 400);    
            }
                
        }

        // 1. Get data yang ada berdasarkan status (penambahan)
        $availableData = Pasien::get_data1_by('id_pasien_status', $request->input('status'), $request->all());
        // 2. Jumlahkan Data yang akan diinsert dengan data yang udah di get sebelumnya sesuai status
        
        $jumlah = $requestData['jumlah'];
        if($availableData->count() > 0) {
            $jumlah += $availableData[0]->sum_jumlah;
        }
        $requestData['sum_jumlah'] = $jumlah;

        // 3. Insert Data
        $data = new \App\Pasien();
        $data->id_kabkota = $requestData['kota'];
        $data->id_pasien_status = $requestData['status'];
        $data->tgl_input = $requestData['tgl_input'];
        $data->jumlah = $requestData['jumlah'];      
        $data->sum_jumlah = $requestData['sum_jumlah'];

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

    public function importCsv(Request $request) {
        // set validation
        

        // set temporary path from uploaded file
        $file = $request->file('uploaded_file');
        $filename = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();

        $valid_ext = ['csv'];

        


        // if uploaded file is csv
        if(in_array(strtolower($ext), $valid_ext)) {
            $location = 'uploads';
            $file->move($location, $filename);

            $filepath = public_path($location . "/" . $filename);
            // Read file
            $file = fopen($filepath, "r");
            $import_data = [];
            $i = 0;
            $columns = fgetcsv($file);

            while(!feof($file)) {
                $import_data[$i][] = fgetcsv($file);
                $i++;
            }
            fclose($file);
            array_pop($import_data);
            $inserted_data = [];$harian = [];
            if(count($import_data) > 0) {
                foreach($import_data as $ind => $row) {
                    
                    // Add for data table
                    if(count($inserted_data) >= 1) {
                        $jumlah = intval($row[0][3]);
                        $arrayStatus = [];
                        foreach($inserted_data as $data) {
                            if($row[0][1] == $data['id_pasien_status'] && $row[0][0] == $data['id_kabkota']) {
                                $arrayStatus[] = $data['sum_jumlah'];    
                            }
                        }

                        $jumlah += end($arrayStatus);

                        $inserted_data[] = [
                            'id_kabkota' => $row[0][0],
                            'id_pasien_status' => $row[0][1],
                            'tgl_input' => $row[0][2],
                            'jumlah' => intval($row[0][3]),
                            'sum_jumlah' => $jumlah
                        ];
                    }
                    else {
                        $inserted_data[] = [
                            'id_kabkota' => $row[0][0],
                            'id_pasien_status' => $row[0][1],
                            'tgl_input' => $row[0][2],
                            'jumlah' => intval($row[0][3]),
                            'sum_jumlah' => intval($row[0][3])
                        ];
                    }

                }

                $inserted = Pasien::insert($inserted_data);
                if($inserted) {
                    return response()->json([
                        'status' => TRUE,
                        'msg' => 'Data berhasil ditambah'
                    ], 200);
                }
                else {
                    return response()->json([
                        'status' => TRUE,
                        'msg' => 'Data gagal ditambah',
                        'array' => $arrayStatus
                    ], 500);
                }

            }
            else {
                return response()->json([
                    'status' => FALSE,
                    'msg' => ['Your file must be have at least 1 data']
                ], 400);
            }
        }
    }

    private function sendError(array $msg, $statusCode) {
        return response()->json([
            'status' => FALSE,
            'msg' => $msg
        ], $statusCode);
    }

    public function infografis() {
        

        // create canvas from image
        $path_image = base_path('public/images/infografis/infografis.jpeg');
        $image = imagecreatefromjpeg($path_image);

        // Add color to canvas
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);

        // Set font
        $font = base_path('public/fonts/BebasNeue-Regular.ttf');

        // Define data
        $rekapitulasi_data = Pasien::get_home_datas();
        $rs = RumahSakit::get_rumah_sakits();
        $data_positif = [ ($rekapitulasi_data['Positif Aktif'] - $rekapitulasi_data['Sembuh']) - $rekapitulasi_data['Meninggal'], $rekapitulasi_data['Sembuh'], $rekapitulasi_data['Meninggal'] ];
        $data_odppdp = [$rekapitulasi_data['Proses ODP'], $rekapitulasi_data['Proses PDP']];

        // Spacer untuk rekapitulasi data
        $positif = [0, 80, 182];
        $odp = [0, 140];
        $result = Pasien::get_datas();

        // Filter Datas
        foreach($result as $i => $data) {
            switch($data->id) {
                case 436: 
                    $datas[] = [
                        'id' => 436,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 223, // start mulai write
                        'startY' => 750
                    ];
                break;
                case 437:
                    $datas[] = [
                        'id' => 437,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 373,
                        'startY' => 750
                    ];
                break;
                case 438:
                    $datas[] = [
                        'id' => 438,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 523,
                        'startY' => 750
                    ];
                break;
                case 439:
                    $datas[] = [
                        'id' => 439,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 673,
                        'startY' => 750
                    ];
                break;
                case 440:
                    $datas[] = [
                        'id' => 440,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 823,
                        'startY' => 750
                    ];
                break;
                case 446:
                    $datas[] = [
                        'id' => 446,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 973,
                        'startY' => 750
                    ];
                break;
                case 445:
                    $datas[] = [
                        'id' => 445,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 73,
                        'startY' => 912
                    ];
                break;
                case 441:
                    $datas[] = [
                        'id' => 441,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 230,
                        'startY' => 912
                    ];
                break;
                case 442:
                    $datas[] = [
                        'id' => 442,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 375,
                        'startY' => 912
                    ];
                break;
                case 476:
                    $datas[] = [
                        'id' => 476,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 530,
                        'startY' => 912
                    ];
                break;
                case 444:
                    $datas[] = [
                        'id' => 444,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 675,
                        'startY' => 912
                    ];
                break;
                case 443:
                    $datas[] = [
                        'id' => 443,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 830,
                        'startY' => 912
                    ];
                break;
                case 447:
                    $datas[] = [
                        'id' => 447,
                        'data' => [ $data->data['Positif Aktif'], ($data->data['Positif Aktif'] - $data->data['Sembuh']) - $data->data['Meninggal'], $data->data['Sembuh'], $data->data['Meninggal'] ],
                        'spacer' => [0, 20, 40, 60],
                        'start' => 985,
                        'startY' => 912
                    ];
                break;
            } // end switch
        }

        // jumlah rs
        for($i = 0;$i < count($rs);$i++) {
            imagettftext($image, 42, 0, 850 + $odp[$i], 600, $black, $font, $rs[$i]);          
        }


        // untuk jumlah data positif
        for($i = 0;$i < count($data_positif);$i++) {
            imagettftext($image, 42, 0, 72 + $positif[$i], 600, $black, $font, $data_positif[$i]);      
        }

        // untuk jumlah data odp pdp
        for($i = 0;$i < count($data_odppdp);$i++) {
            imagettftext($image, 42, 0, 470 + $odp[$i], 600, $black, $font, $data_odppdp[$i]);      
        }
        // Sebaran Covid 19
        foreach($datas as $i => $data) {
            for($x = 0;$x < count($data['data']);$x++) {
                imagettftext($image, 16, 0, $data['start'],$data['startY'] + $data['spacer'][$x], $white, $font, $data['data'][$x]);
            }
        }

        header('Content-Type: image/jpeg');

        imagejpeg($image);
        imagedestroy($image);
    }
}
