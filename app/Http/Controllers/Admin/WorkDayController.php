<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\WorkDay;
use App\Models\Admin\WorkDayTmp;
use App\Imports\WorkDayTmpImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class WorkDayController extends Controller
{
    public function index()
    {
        return view('Admin.WorkDay.index', [
            'title' => 'WorkDay'
        ]);
    }

    public function data(Request $request)
    {
        $data = WorkDay::orderBy('WorkDate', 'ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = "<a href='javascript:void(0)' class='btn btn-sm btn-primary' onclick='editData(" . json_encode($row) . ")'><i class=\"fa fa-edit\"></i> Edit</a>";
                $del  = "<a href='javascript:void(0)' class='btn btn-sm btn-danger' onclick='deleteData(" . json_encode($row) . ")'><i class=\"fa fa-trash\"></i> Hapus</a>";
                return $edit . ' ' . $del;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'WorkDate'    => 'required|date',
            'StatusDay'   => 'nullable|max:50',
            'NoteDay'     => 'nullable|max:100',
            'StatusLabel' => 'nullable|max:50',
            'EXPDT'       => 'nullable|integer',
        ]);

        if (WorkDay::where('WorkDate', $validated['WorkDate'])->exists()) {
            return response()->json(['success' => false, 'message' => 'WorkDate sudah ada!'], 422);
        }

        WorkDay::create($validated);

        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan.']);
    }

    public function update(Request $request, $workdate)
    {
        $validated = $request->validate([
            'WorkDate'    => 'required|date',
            'StatusDay'   => 'nullable|max:50',
            'NoteDay'     => 'nullable|max:100',
            'StatusLabel' => 'nullable|max:50',
            'EXPDT'       => 'nullable|integer',
        ]);

        $exists = WorkDay::where('WorkDate', $validated['WorkDate'])
            ->where('WorkDate', '!=', $workdate)
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'WorkDate sudah ada!'], 422);
        }

        $row = WorkDay::where('WorkDate', $workdate)->firstOrFail();
        $row->update($validated);

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
    }

    public function destroy($workdate)
    {
        WorkDay::where('WorkDate', $workdate)->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        // Kosongkan tabel sementara sebelum import
        WorkDayTmp::truncate();

        // Import ke tabel sementara
        Excel::import(new WorkDayTmpImport, $request->file('file'));

        // Jalankan stored procedure setelah import
        DB::statement('EXEC [dbo].[SP_WORKDAY_A]');

        return response()->json(['success' => true, 'message' => 'Import dan proses berhasil!']);
    }
}
