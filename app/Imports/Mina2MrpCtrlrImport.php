<?php

namespace App\Imports;

use App\Models\Admin\Mina2MrpCtrlr;
use Maatwebsite\Excel\Concerns\ToModel;

class Mina2MrpCtrlrImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Lewati baris header jika perlu
        if ($row[0] == 'MRP_CTRL') return null;

        return new Mina2MrpCtrlr([
            'MRP_CTRL' => $row[0],
            'WRK_CNTR' => $row[1],
            'MRP_NAME' => $row[2],
            'PLANT'    => $row[3],
        ]);
    }
}
