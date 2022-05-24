<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class MasterKey extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    protected $guarded = 'id';

    protected $hidden = [
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'key'
    ];
    
    protected $dates = [
        'numbers_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'numbers_date' => 'datetime:d-m-Y H:i:s',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];
}
