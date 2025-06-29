<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class PartLabelImport implements ToCollection
{
    protected $successCount = 0;

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function collection(Collection $collection)
    {
        if ($collection->isEmpty()) return;

        // Ambil header dari baris pertama, pastikan lowercase dan trim
        $header = $collection->first()->map(function($item) {
            return strtolower(trim($item));
        })->toArray();

        // Loop data mulai baris kedua
        foreach ($collection->slice(1) as $row) {
            // Lewati baris kosong
            if ($row->filter()->isEmpty()) continue;

            // Pastikan jumlah kolom sama dengan header
            if (count($row) < count($header)) continue;

            $data = array_combine($header, $row->toArray());

            // Pastikan kolom matnr ada dan tidak kosong
            if (!isset($data['matnr']) || empty($data['matnr'])) continue;

            // Insert/update ke database
            DB::table('ms_part_label')->updateOrInsert(
                ['MATNR' => $data['matnr']],
                [
                    'WERKS'        => $data['werks'] ?? null,
                    'MATNR'        => $data['matnr'] ?? null,
                    'MAKTX'        => $data['maktx'] ?? null,
                    'ARBPL'        => $data['arbpl'] ?? null,
                    'VORNR'        => $data['vornr'] ?? null,
                    'EXTWG'        => $data['extwg'] ?? null,
                    'LTXA1W'       => $data['ltxa1w'] ?? null,
                    'ZZP_NUM_ENT'  => isset($data['zzp_num_ent']) ? str_replace(',', '.', $data['zzp_num_ent']) : null,
                    'BUN'          => $data['bun'] ?? null,
                    'MRP'          => $data['mrp'] ?? null,
                    'PLANT'        => $data['plant'] ?? null,
                    'LNNM'         => $data['lnnm'] ?? null,
                    'VSBL'         => $data['vsbl'] ?? null,
                ]
            );
            $this->successCount++;
        }
    }
}
