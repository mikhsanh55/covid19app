<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'wilayah_kecamatan';

    public function pasien()
    {
    	return $this->hasMany('App\Pasien');
    }
}
