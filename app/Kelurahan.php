<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'wilayah_kelurahan';

    public function pasien()
    {
    	return $this->hasMany('App\Pasien');
    }
}
