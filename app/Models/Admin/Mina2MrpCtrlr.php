<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Mina2MrpCtrlr extends Model
{
    protected $table = 'mina2_mrp_ctrlr';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'MRP_CTRL', 'WRK_CNTR', 'MRP_NAME', 'PLANT'
    ];
}