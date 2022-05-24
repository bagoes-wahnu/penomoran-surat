<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    protected $connection= 'pgsql2';
    protected $table = 'pegawai';
    protected $primaryKey = 'pgw_id';
}
