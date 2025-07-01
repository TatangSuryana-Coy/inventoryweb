<?php

namespace App\Imports;

use App\Models\Admin\Mina2MrpCtrlr;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Mina2MrpCtrlrImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pastikan semua kolom ada
        if (!isset($row['mrp_ctrl']) || !isset($row['wrk_cntr']) || !isset($row['mrp_name']) || !isset($row['plant'])) {
            return null;
        }

        // Cek apakah data sudah ada
        $data = Mina2MrpCtrlr::where('WRK_CNTR', $row['wrk_cntr'])->first();

        if ($data) {
            // Jika sudah ada, update MRP_CTRL, MRP_NAME, dan PLANT
            $data->update([
                'MRP_CTRL' => $row['mrp_ctrl'],
                'MRP_NAME' => $row['mrp_name'],
                'PLANT'    => $row['plant'],
            ]);
            return null; // Tidak insert baru
        } else {
            // Jika belum ada, insert baru
            return new Mina2MrpCtrlr([
                'MRP_CTRL' => $row['mrp_ctrl'],
                'WRK_CNTR' => $row['wrk_cntr'],
                'MRP_NAME' => $row['mrp_name'],
                'PLANT'    => $row['plant'],
            ]);
        }
    }
}
