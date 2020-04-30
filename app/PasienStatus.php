<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasienStatus extends Model
{
    protected $table = 'pasien_status';

    public function pasien()
    {
    	return $this->hasOne('App\Pasien');
    }
}
