<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class RumahSakit extends Model
{
    protected $table = 'rumah_sakits';
    protected $fillable = ['nama', 'alamat', 'no', 'ket', 'rujukan'];

    public function Scopeget_rumah_sakits() {
    	$rs = DB::table('rumah_sakits')
    				->select(DB::raw('COUNT(*) as jumlah, rujukan'))
    				->where('rujukan', 0)
    				->get();
    	if($rs->count() > 0) {
    		$datas[] = $rs[0]->jumlah;
    	}
    	else {
    		$datas[] = 0;	
    	}

    	$rs_rujukan = DB::table('rumah_sakits')
    				->select(DB::raw('COUNT(*) as jumlah, rujukan'))
    				->where('rujukan', 1)
    				->get();
    	if($rs_rujukan->count() > 0) {
    		$datas[] = $rs_rujukan[0]->jumlah;
    	}
    	else {
    		$datas[] = 0;	
    	}


    	return $datas;
    }
}
