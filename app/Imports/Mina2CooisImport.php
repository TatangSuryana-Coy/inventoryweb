<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class Mina2CooisImport implements ToCollection
{
    protected $successCount = 0;

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function collection(Collection $collection)
    {
        if ($collection->isEmpty()) return;

        $header = $collection->first()->map(function($item) {
            return strtolower(trim($item));
        })->toArray();

        foreach ($collection->slice(1) as $row) {
            if ($row->filter()->isEmpty()) continue;
            if (count($row) < count($header)) continue;

            $data = array_combine($header, $row->toArray());

            // Pastikan kolom mat_number ada dan tidak kosong
            if (!isset($data['mat_number']) || empty($data['mat_number'])) continue;

            DB::table('mina2_coois')->updateOrInsert(
                ['MAT_NUMBER' => $data['mat_number']],
                [
                    'MRP'             => $data['mrp'] ?? null,
                    'MAT_NUMBER'      => $data['mat_number'] ?? null,
                    'MAT_DESCRIPTION' => $data['mat_description'] ?? null,
                    'PROD_ORDER'      => $data['prod_order'] ?? null,
                    'SYS_STATUS'      => $data['sys_status'] ?? null,
                    'CHG_BY'          => $data['chg_by'] ?? null,
                    'CHG_TIME'        => $data['chg_time'] ?? null,
                    'CRT_TIME'        => $data['crt_time'] ?? null,
                    'BSC_START'       => $this->excelDateToDate($data['bsc_start'] ?? null),
                    'BSC_FINISH'      => $this->excelDateToDate($data['bsc_finish'] ?? null),
                    'ORD_QTY'         => $data['ord_qty'] ?? null,
                    'ACT_PROD'        => $data['act_prod'] ?? null,
                    'UNIT'            => $data['unit'] ?? null,
                    'CRT_DATE'        => $this->excelDateToDate($data['crt_date'] ?? null),
                    'CHG_DATE'        => $this->excelDateToDate($data['chg_date'] ?? null),
                    // Kolom lain jika diperlukan
                ]
            );
            $this->successCount++;
        }
    }

    protected function excelDateToDate($value)
    {
        // Jika sudah string tanggal, langsung return
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) return $value;
        // Jika null atau kosong
        if (!$value) return null;
        // Jika numeric (serial Excel)
        if (is_numeric($value)) {
            // Excel serial date to PHP date
            return date('Y-m-d', ($value - 25569) * 86400);
        }
        return $value;
    }
}