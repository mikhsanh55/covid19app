<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kabkota extends Model
{
    protected $table = 'wilayah_kabkota';

    public function pasien()
    {
    	return $this->hasMany('App\Pasien', 'id_kabkota');
    }
}
