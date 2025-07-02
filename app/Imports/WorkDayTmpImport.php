<?php

namespace App\Imports;

use App\Models\Admin\WorkDayTmp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WorkDayTmpImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['workdate'])) return null;

        $workDate = $row['workdate'];
        if (is_numeric($workDate)) {
            $workDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($workDate)->format('Y-m-d');
        }

        return new WorkDayTmp([
            'WorkDate'    => $workDate,
            'StatusDay'   => $row['statusday'] ?? null,
            'NoteDay'     => $row['noteday'] ?? null,
            'StatusLabel' => $row['statuslabel'] ?? null,
        ]);
    }
}
