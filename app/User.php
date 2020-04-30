<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use AuthenticableTrait;
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];

}
