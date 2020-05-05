<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Arcgis extends Model
{
    protected $table = 'arcgis';
    protected $fillable = ['src'];

    public function ScopefirstRecord() {
    	return DB::table($this->table)->get()->first();
    }
}
