<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class testModel extends Authenticatable
{
    protected $table = 'hb_admin';
    protected $primaryKey = 'id';

    public $fillable = ['id','uname','password'];
}
