<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    protected $table = 'rumah_sakits';
    protected $fillable = ['nama', 'alamat', 'no', 'ket', 'rujukan'];
}
