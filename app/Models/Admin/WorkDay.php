<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class WorkDay extends Model
{
    protected $table = 'workday';
    protected $primaryKey = 'WorkDate'; // <-- tambahkan ini
    public $incrementing = false;       // <-- tambahkan ini
    protected $keyType = 'string';      // <-- tambahkan ini jika WorkDate tipe string/date
    public $timestamps = false;
    protected $fillable = [
        'WorkDate',
        'StatusDay',
        'NoteDay',
        'StatusLabel',
        'EXPDT'
    ];
}
