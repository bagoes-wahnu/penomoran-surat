<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class LetterNumber extends Model
{
    use HasFactory, SoftDeletes, Userstamps;


    protected $fillable = [
        'start_at',
        'end_in',
        'numbers_date',
        'locked_at',
        'locked_id',
        'sector_id',
        'regarding',
        'letter_code',
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function setNumbersDateAttribute($value)
    {
        $this->attributes['numbers_date'] = (new Carbon($value))->format('Y-m-d');
    }
}
