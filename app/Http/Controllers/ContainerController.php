<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pasien;
use App\Slider;
use App\RumahSakit;
use App\Kontak;
use App\NoDarurat;
use App\Arcgis;
class ContainerController extends Controller
{

    public function index()
    {   
        // print_r(Pasien::get_home_datas());exit;
        return view('home/index', [
            'slides' => Slider::all(),
            'rumah_sakit' => RumahSakit::where('rujukan', '1')->get(),
            'kontaks' => Kontak::all(),
            'no_darurat' => NoDarurat::first(),
            'no' => 0,
            'data_per_status' => Pasien::get_home_datas(),
            'latest_update' => Pasien::get_latest_update(),
            'arcgis_src' => Arcgis::firstRecord()->src
        ]);
    }

    public function kontak()
    {
        return view('home/kontak');
    }

    public function get_data_chart()
    {
        // print_r(Pasien::get_data_chart());exit;
        $data_pasiens = Pasien::get_data_chart();

        // print_r($data_pasiens);exit;
        $tanggal = array_keys($data_pasiens);
        $data_sembuh = [];$data_meninggal = [];$data_aktif = [];
        $data_odp = [];$data_pdp = [];$data_otg = [];
        $data_pasiens = array_slice($data_pasiens, 0);
        $i = 0;

        // Change key to numeric
        foreach($data_pasiens as $key => $data) {
            $data_pasiens[$i] = $data_pasiens[$key];
            unset($data_pasiens[$key]);
            $i++;
        }
        $data_pasiens = array_reverse($data_pasiens);
        foreach($data_pasiens as $i  => $data) {

            //  if($i > 0) {
            //     $data_pasiens[$i]['data']['ODP'] = $data_pasiens[$i]['data']['ODP'] + $data_pasiens[$i-1]['data']['ODP'];
            //     $data_pasiens[$i]['data']['PDP'] = $data_pasiens[$i]['data']['PDP'] + $data_pasiens[$i-1]['data']['PDP'];
            //     $data_pasiens[$i]['data']['OTG'] = $data_pasiens[$i]['data']['OTG'] + $data_pasiens[$i-1]['data']['OTG'];
            //     $data_pasiens[$i]['data']['Sembuh'] = $data_pasiens[$i]['data']['Sembuh'] + $data_pasiens[$i-1]['data']['Sembuh'];
            //     $data_pasiens[$i]['data']['Meninggal'] = $data_pasiens[$i]['data']['Meninggal'] + $data_pasiens[$i-1]['data']['Meninggal'];
            //     $data_pasiens[$i]['data']['Positif Aktif'] = $data_pasiens[$i]['data']['Positif Aktif'] + $data_pasiens[$i-1]['data']['Positif Aktif'];
            // }

            $data_sembuh[] = $data_pasiens[$i]['data']['Sembuh'];
            $data_aktif[] = $data_pasiens[$i]['data']['Positif Aktif'];
            $data_meninggal[] = $data_pasiens[$i]['data']['Meninggal'];
            $data_odp[] = $data_pasiens[$i]['data']['ODP'];
            $data_pdp[] = $data_pasiens[$i]['data']['PDP'];
            $data_otg[] = $data_pasiens[$i]['data']['OTG'];
        }
        // print_r($data_pasiens);exit;
        
        return response()->json([
            'status' => TRUE,
            'tanggal' => array_reverse($tanggal),
            'data' => [
               'sembuh' => $data_sembuh,
               'aktif' => $data_aktif,              
               'meninggal' => $data_meninggal,
               'odp' => $data_odp,
               'pdp' => $data_pdp,
               'otg' => $data_otg
            ]
        ], 200);
    }

    public function get_all_coordinates()
    {   
        // print_r(Pasien::get_datas_map());exit;
        $data_pasiens = Pasien::get_datas_map();
        $datas = [];    
        return response()->json([
            'status' => TRUE,
            'data' => $data_pasiens
        ], 200);
    }
}
