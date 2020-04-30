<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoDarurat extends Model
{
    protected $table = 'no_darurats';
    protected $fillable = ['call_center', 'no_diskes'];
}
