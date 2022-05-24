<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    protected $connection= 'pgsql2';
    protected $table = 'surat';
    protected $primaryKey = 'srt_id';

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'srt_pgw_id', 'srt_id');
    }
}
