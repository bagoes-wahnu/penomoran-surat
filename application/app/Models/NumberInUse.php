<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberInUse extends Model
{
    use HasFactory;

    protected $table = 'number_in_use';

    protected $primaryKey = 'id';

    // protected $guarded = [
    //     'id'
    // ];

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'surat_id', 'srt_id');
    }
}
