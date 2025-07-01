<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Mina2MrpCtrlr extends Model
{
    protected $table = 'mina2_mrp_ctrlr';
    public $timestamps = false;
    protected $primaryKey = 'WRK_CNTR'; // WRK_CNTR sebagai primary key
    public $incrementing = false;
    protected $keyType = 'string'; // Jika WRK_CNTR bukan integer
    protected $fillable = [
        'MRP_CTRL', 'WRK_CNTR', 'MRP_NAME', 'PLANT'
    ];
}