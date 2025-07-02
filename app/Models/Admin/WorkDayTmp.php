<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class WorkDayTmp extends Model
{
    protected $table = 'workday_tmp';
    public $timestamps = false;
    protected $fillable = [
        'WorkDate',
        'StatusDay',
        'NoteDay',
        'StatusLabel'
    ];
}
