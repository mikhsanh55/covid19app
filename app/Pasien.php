<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class Pasien extends Model
{
    protected $guarded = [];
    protected $table = 'pasiens';
    private $latest_date;
    protected $fillable = ['id_kabkota', 'id_kecamatan', 'id_kelurahan', 'id_pasien_status', 'nama', 'nik', 'umur', 'jk', 'tgl_input', 'rawat', 'latitude', 'longitude', 'jumlah', 'sum_jumlah'];

    // Untuk kepentingan Join
    public function __construct()
    {
        ini_set('date.timezone', 'Asia/Jayapura');
        $this->latest_date = $this->get_latest_date();
    }
    public function pasien_status()
    {
        return $this->belongsTo('App\PasienStatus', 'id_pasien_status');
    }

    public function kabkota()
    {
        return $this->belongsTo('App\Kabkota', 'id_kabkota');
    }

    public function kecamatan()
    {
        return $this->belongsTo('App\Kecamatan', 'id_kecamatan');
    }

    public function kelurahan()
    {
        return $this->belongsTo('App\Kelurahan', 'id_kelurahan');
    }

    // Untuk Data kalkulasi di Home page, jumlah pasien per status
    public function Scopeget_short_datas()
    {
        $datas = DB::table('pasiens as p')
                    ->select(DB::raw('p.id_kabkota, s.value, SUM(jumlah) as jml, s.key as status, wk.nama'))
                    ->rightJoin('pasien_status as s', 'p.id_pasien_status', '=', 's.key')
                    ->join('wilayah_kabkota as wk', 'p.id_kabkota', '=', 'wk.id')
                    ->groupBy('s.key', 'p.id_kabkota', 's.value', 'wk.nama')
                    ->orderBy('p.tgl_input', 'desc')
                    ->get();
        foreach ($datas as $key => $pasien) {
            $pasien->encrypt_id = Crypt::encrypt($pasien->id_kabkota);
            if($pasien->status == 1) {
                $pasien->nama_status = 'Sembuh';
            }
            else if($pasien->status == 2) {
                $pasien->nama_status = 'Positif Aktif';
            }
            else if($pasien->status == 3) {
                $pasien->nama_status = 'Meninggal';
            }
            else if($pasien->status == 4) {
                $pasien->nama_status = 'ODP';
            }
            else if($pasien->status == 5) {
                $pasien->nama_status = 'PDP';
            }
            else if($pasien->status == 6) {
                $pasien->nama_status = 'OTG';
            }
            else if($pasien->status == 7) {
                $pasien->nama_status = 'Selesai ODP';
            }
            else if($pasien->status == 8) {
                $pasien->nama_status = 'Selesai PDP';
            }
            else if($pasien->status == 11) {
                $pasien->nama_status = 'Selesai OTG';
            }
        }
        return $datas;
    }

    // Untuk fitur update terakhir
    public function Scopeget_latest_date()
    {
        $res = '';
        $result = DB::table('pasiens as p')
                            ->select(DB::raw('MAX(tgl_input) as latest_date'))
                            ->groupBy('p.id_kabkota')
                            ->get();
        if($result->count() > 0) {
            $res = $result[0]->latest_date;
        }
        else {
            $res = date('d-m-Y H:s');
        }
        return $res;
    }

    // Untuk table data pasien
    public function Scopeget_datas($query, $where = NULL)
    {
        
        if($where != NULL) {
            $this->latest_date = $where;
        }
        else {
            $this->latest_date = $this->get_latest_date();
        }
        // Get semua kota di Papua Barat
        $kotas = DB::table('wilayah_kabkota as wk')
                    ->where('wk.id_provinsi', 33)
                    ->get();
        foreach ($kotas as $i => $kota) {
            $kota->encrypt_id = Crypt::encrypt($kota->id);
            $kota->data = [];
        }
 
        // Get semua data pasien di group berdasarkan statusnya
        $datas = DB::table('pasiens as p')
                    ->select(DB::raw('p.id_kabkota, s.value, SUM(jumlah) as jml, p.id_pasien_status as status, tgl_input, sum_jumlah'))
                    ->join('pasien_status as s', 'p.id_pasien_status', '=', 's.key')
                    ->where('tgl_input', '<=', $this->latest_date)
                    ->groupBy('p.id_pasien_status', 'p.id_kabkota', 's.value', 'p.tgl_input')
                    ->orderBy('tgl_input', 'desc')
                    ->get();
        $category = ['Sembuh', 'Positif Aktif', 'Meninggal', 'Selesai ODP', 'Proses ODP', 'Selesai PDP', 'Proses PDP', 'Selesai OTG', 'Proses OTG'];

        // Cocokan, jika cocok masukan data pasien ke data kota 
        foreach ($kotas as $i => $kota) {
            foreach ($datas as $key => $data) {
                // Seleksi data, ambil data yang ada diantara 3 kategori Positif, ODP, PDP, dan OTG
                if($data->id_kabkota == $kota->id) {
                    if($data->tgl_input == $this->check_latest_date($data)) {
                        $kota->data[$data->value][] = $data->sum_jumlah;    
                    }
                    // else {
                    //     unset($datas[$key]);
                    // }
                    
                }
            }
            $category = ['Sembuh', 'Positif Aktif', 'Meninggal', 'Selesai ODP', 'Proses ODP', 'Selesai PDP', 'Proses PDP', 'Selesai OTG', 'Proses OTG'];
            // Lengkapi data yang tidak ada dengan diisi 0
            for($i = 0;$i < count($category);$i++) {
                if(!isset($kota->data[$category[$i]])) {
                    $kota->data[$category[$i]] = 0;
                }
                else {
                    $kota->data[$category[$i]] = $kota->data[$category[$i]][0];
                }
            }
            $kota->encrypt_id = Crypt::encrypt($kota->id);
        }   
        return $kotas;            
    }

    /*
    * Untuk seleksi data berdasarkan kategori status
    * @return tanggal terbaru dari data  
    */
    private function check_latest_date($data, $single = false) {
        $whereIn = [];
        if($single == false) {
                        $whereIn = [$data->status];
        }
        else {
            $whereIn = [$data->status];
        }    
        $check = DB::table('pasiens')
                        ->select(DB::raw('MAX(tgl_input) as latest_date, id_pasien_status, jumlah, id_kabkota'))
                        ->whereIn('id_pasien_status', $whereIn)
                        ->where('id_kabkota', $data->id_kabkota)
                        ->whereDate('tgl_input', '<=', $data->tgl_input)
                        ->groupBy('id_kabkota', 'id_pasien_status', 'jumlah')
                        ->orderBy('latest_date', 'desc')
                        ->get();
        return $check[0]->latest_date;
    }

    // Untuk data harian
    public function Scopeget_detail($query, $id, $whereIn = NULL)
    {
        if($whereIn != NULL) {
            $datas = DB::table('pasiens as p')
                        ->select(DB::raw('p.id, p.id_kabkota, s.value, SUM(jumlah) as jml, s.key as status, p.tgl_input, wk.nama'))
                        ->rightJoin('pasien_status as s', 'p.id_pasien_status', '=', 's.key')
                        ->join('wilayah_kabkota as wk', 'p.id_kabkota', '=', 'wk.id')
                        ->where('p.id_kabkota', $id)
                        ->whereIn('p.tgl_input', [$whereIn])
                        ->groupBy('s.key', 'p.id_kabkota', 's.value', 'p.tgl_input', 'wk.nama', 'p.id')
                        ->orderBy('p.tgl_input', 'desc')
                        ->get(); 
        }
        else {
            $datas = DB::table('pasiens as p')
                        ->select(DB::raw('p.id, p.id_kabkota, s.value, SUM(jumlah) as jml, s.key as status, p.tgl_input, wk.nama'))
                        ->rightJoin('pasien_status as s', 'p.id_pasien_status', '=', 's.key')
                        ->join('wilayah_kabkota as wk', 'p.id_kabkota', '=', 'wk.id')
                        ->where('p.id_kabkota', $id)
                        ->groupBy('s.key', 'p.id_kabkota', 's.value', 'p.tgl_input', 'wk.nama', 'p.id')
                        ->orderBy('p.tgl_input', 'desc')
                        ->get(); 
        }
            

        foreach($datas as $data) {
            $data->encrypt_id = Crypt::encrypt($data->id);
        }       
        return $datas;
    }

    // Function untuk mengambil data untuk action edit dan update di PasienController
    // saat ini belum digunakan
    public function Scopeget_data2($query, $id)
    {
        $id = intval($id);
        // Get semua kota di Papua Barat
        $kota = DB::table('wilayah_kabkota as wk')
                    ->where('wk.id', $id)
                    ->first();
        
            $kota->encrypt_id = Crypt::encrypt($kota->id);
            $kota->data = [];
        

        // Get semua data pasien di group berdasarkan statusnya
        $datas = DB::table('pasiens as p')
                    ->select(DB::raw('p.id_kabkota, s.value, SUM(jumlah) as jml, s.key as status, wk.nama'))
                    ->rightJoin('pasien_status as s', 'p.id_pasien_status', '=', 's.key')
                    ->join('wilayah_kabkota as wk', 'p.id_kabkota', '=', 'wk.id')
                    ->groupBy('s.key', 'p.id_kabkota', 's.value', 'wk.nama')
                    ->get();

        // Cocokan, jika cocok masukan data pasien ke data kota 
        
        foreach ($datas as $key => $data) {
            if($data->id_kabkota == $kota->id) {
                $kota->data[$data->value] = $data->jml;
            }
        }
        return $kota;
    }

    /*
    * Untuk menampilkan semua status di dalam API Maps Openlayers
    * @return array
    */
    public function Scopeget_coordinates()
    {
        // Set global date to latest updated date in db
        $this->latest_date = $this->get_latest_date();

        // get datas
        $kotas = Pasien::get_datas();

        foreach($kotas as $i => $kota) {
            $kota->data['Proses ODP'] = $kota->data['Proses ODP'] - $kota->data['Selesai ODP'];
            $kota->data['Proses PDP'] = $kota->data['Proses PDP'] - $kota->data['Selesai PDP'];
            $kota->data['Proses OTG'] = $kota->data['Proses OTG'] - $kota->data['Selesai OTG'];
            $kota->data['Positif Aktif'] = ($kota->data['Positif Aktif'] - $kota->data['Sembuh']) - $kota->data['Meninggal'];
        }

        return $kotas;
    }

    /*
    *   Return array sum of datas for Positif, ODP, PDP, OTG for All Cities in West Papua
    *   @return array
    */
    public function Scopeget_home_datas()
    {
        $result = DB::table('pasiens as p')
                    ->select(DB::raw('SUM(p.jumlah) as jml, s.key, s.value'))
                    ->join('pasien_status as s', 'p.id_pasien_status', '=', 's.key')
                    ->groupBy('s.key', 's.value')
                    ->get();
        $data = [];
        $category = ['Sembuh', 'Positif Aktif', 'Meninggal', 'ODP', 'Selesai ODP', 'Proses ODP', 'PDP', 'Selesai PDP', 'Proses PDP', 'OTG', 'Selesai OTG', 'Proses OTG'];
        foreach($result as $res) {
            $data[$res->value] = $res->jml;
        }
        for($i = 0;$i < count($category);$i++) {
            if(!isset($data[$category[$i]])) {
                $data[$category[$i]] = 0;
            }
        }
        return $data;            
    }

    /*
    * Untuk menampilkan data di Chart halaman Home
    * @return array  
    */
    public function Scopeget_data_chart()
    {
        $result = DB::table('pasiens as p')
                        ->select(DB::raw('p.tgl_input, SUM(p.jumlah) as jml, p.tgl_input, st.value'))
                        ->join('pasien_status as st', 'p.id_pasien_status', '=', 'st.key')
                        ->groupBy('p.tgl_input', 'p.jumlah', 'st.value')
                        ->orderBy('p.tgl_input', 'DESC')
                        ->get();
        $datas = [];
        $tanggal = []; // buat tanggal

        // Ubah structure result jadikan tgl sebagai key dari object
        foreach($result as $i => $data) {
            array_push($tanggal, $data->tgl_input);
        }   
        $counter = 0;
        foreach($result as $i => $data) {
            for($j = 0;$j < count($tanggal);$j++) {
                if($data->tgl_input == $tanggal[$j]) {
                    $datas[$data->tgl_input][$i] = $data; 
                }
            }
        }

        foreach($datas as $i => $data) {
            $datas[$i]['data'] = [];
            foreach($data as $key => $d) {
                switch($d->value) {
                    case 'Sembuh':
                        $datas[$i]['data']['Sembuh'][] = $d->jml;
                    break;

                    case 'Meninggal':
                        $datas[$i]['data']['Meninggal'][] = $d->jml;
                    break;

                    case 'Positif Aktif':
                        $datas[$i]['data']['Positif Aktif'][] = $d->jml;
                    break;

                    case 'Proses ODP':
                        $datas[$i]['data']['ODP'][] = $d->jml;
                    break;

                    case 'Selesai ODP':
                        $datas[$i]['data']['ODPS'][] = $d->jml;
                    break;

                    case 'Proses PDP':
                        $datas[$i]['data']['PDP'][] = $d->jml;
                    break;

                    case 'Selesai PDP':
                        $datas[$i]['data']['PDPS'][] = $d->jml;
                    break;

                    case 'Proses OTG':
                        $datas[$i]['data']['OTG'][] = $d->jml;
                    break;

                    case 'Selesai OTG':
                        $datas[$i]['data']['OTGS'][] = $d->jml;
                    break;
                }
            }
        }

        // Sum all array data
        foreach($datas as $i => $data) {
            if(isset($datas[$i]['data']['Sembuh'])) {
                $datas[$i]['data']['Sembuh'] = array_sum($datas[$i]['data']['Sembuh']);    
            }
            else {
                $datas[$i]['data']['Sembuh'] = 0;       
            }
            if(isset($datas[$i]['data']['Meninggal'])) {
                $datas[$i]['data']['Meninggal'] = array_sum($datas[$i]['data']['Meninggal']);
            }
            else {
                $datas[$i]['data']['Meninggal'] = 0;       
            }
            if(isset($datas[$i]['data']['Positif Aktif'])) {
                $datas[$i]['data']['Positif Aktif'] = array_sum($datas[$i]['data']['Positif Aktif']);
            }
            else {
                $datas[$i]['data']['Positif Aktif'] = 0;       
            }
            if(isset($datas[$i]['data']['ODP'])) {
                $datas[$i]['data']['ODP'] = array_sum($datas[$i]['data']['ODP']);
            }
            else {
                $datas[$i]['data']['ODP'] = 0;       
            }

            if(isset($datas[$i]['data']['ODPS'])) {
                $datas[$i]['data']['ODPS'] = array_sum($datas[$i]['data']['ODPS']);
            }
            else {
                $datas[$i]['data']['ODPS'] = 0;       
            }
            if(isset($datas[$i]['data']['PDP'])) {
                $datas[$i]['data']['PDP'] = array_sum($datas[$i]['data']['PDP']);
            }
            else {
                $datas[$i]['data']['PDP'] = 0;       
            }
            if(isset($datas[$i]['data']['PDPS'])) {
                $datas[$i]['data']['PDPS'] = array_sum($datas[$i]['data']['PDPS']);
            }
            else {
                $datas[$i]['data']['PDPS'] = 0;       
            }
            if(isset($datas[$i]['data']['OTG'])) {
                $datas[$i]['data']['OTG'] = array_sum($datas[$i]['data']['OTG']);
            }
            else {
                $datas[$i]['data']['OTG'] = 0;       
            }
            if(isset($datas[$i]['data']['OTGS'])) {
                $datas[$i]['data']['OTGS'] = array_sum($datas[$i]['data']['OTGS']);
            }
            else {
                $datas[$i]['data']['OTGS'] = 0;       
            }
        }

        return $datas;         
    }

    /*
    * Untuk menampilkan Tanggal update terakhir
    * di Halaman Home  
    *
    * @return string
    */
    public function Scopeget_latest_update() {
        
        $latest_date = DB::table('pasiens')
                        ->orderBy('updated_at', 'DESC')    
                        ->get();
        if(!$latest_date->isEmpty()) {
            $latest_date = $latest_date[0]->updated_at;
        }                
        else {
            $latest_date = date('d-m-Y H:i');
        }
        return $this->switch_indo_day($latest_date);
    }

    /*
    * Untuk switch hari dalam inggris ke indo
    * @return string date  
    */
    private function switch_indo_day($date) {
        $hari = date('D', strtotime($date));
        switch($hari){
            case 'Sun':
                $hari = "Minggu";
            break;
     
            case 'Mon':         
                $hari = "Senin";
            break;
     
            case 'Tue':
                $hari = "Selasa";
            break;
     
            case 'Wed':
                $hari = "Rabu";
            break;
     
            case 'Thu':
                $hari = "Kamis";
            break;
     
            case 'Fri':
                $hari = "Jumat";
            break;
     
            case 'Sat':
                $hari = "Sabtu";
            break;
            
            default:
                $hari = "Tidak di ketahui";     
            break;
        }
        return $hari . ', ' . date('d-m-Y H:i', strtotime($date));
    }

    public function Scopeget_data_by($query, $field, $where, $datas) {
        $result = DB::table($this->table)
                        ->where($field, $where)
                        ->where('id_kabkota', $datas['kota'])
                        ->orderBy('tgl_input', 'desc')
                        ->get();

        return $result;
    }
    public function Scopeget_data1_by($query, $field, $where, $datas) {
        $result = DB::table($this->table)
                        ->where($field, $where)
                        ->where('id_kabkota', $datas['kota'])
                        ->orderBy('tgl_input', 'desc')
                        ->get();

        return $result;
    }

    public function Scopeget_sum_by($query, $field, $where, $datas) {
        $result = DB::table($this->table)
                        ->select(DB::raw('SUM(jumlah) as jml'))
                        ->where($field, $where)
                        ->where('id_kabkota', $datas['kota'])
                        ->groupBy('jumlah')
                        ->get();
        $sum = 0;               
        foreach($result as $res) {
            $sum += $res->jml;
        }

        return $sum;    
    }

}