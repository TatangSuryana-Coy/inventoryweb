<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Mina2MrpCtrlr;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Mina2MrpCtrlrImport;

class MrpCtrlrController extends Controller
{
    public function index()
    {
        return view('Admin.MRPController.index', [
            'title' => 'MRP Controller'
        ]);
    }

    public function data(Request $request)
    {
        $data = Mina2MrpCtrlr::orderByRaw('MRP_CTRL ASC, WRK_CNTR ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $edit = "<a href='javascript:void(0)' class='btn btn-sm btn-warning text-white' onclick='editData(".json_encode($row).")'>
                            <i class=\"fa fa-edit\"></i> Edit
                        </a>";
                $del  = "<a href='javascript:void(0)' class='btn btn-sm btn-danger' onclick='deleteData(".json_encode($row).")'>
                            <i class=\"fa fa-trash\"></i> Hapus
                        </a>";
                return $edit . ' ' . $del;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'MRP_CTRL' => 'required|max:4',
            'WRK_CNTR' => 'required|max:7',
            'MRP_NAME' => 'required|max:30',
            'PLANT'    => 'required|max:5',
        ]);

        // Cek duplikat WRK_CNTR
        if (Mina2MrpCtrlr::where('WRK_CNTR', $validated['WRK_CNTR'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'WRK_CNTR sudah digunakan!'
            ], 422);
        }

        Mina2MrpCtrlr::create($validated);

        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan.']);
    }

    public function update(Request $request, $wrk_cntr)
    {
        $validated = $request->validate([
            'MRP_CTRL' => 'required|max:4',
            'WRK_CNTR' => 'required|max:7',
            'MRP_NAME' => 'required|max:30',
            'PLANT'    => 'required|max:5',
        ]);

        // Cek duplikat WRK_CNTR baru (kecuali milik sendiri)
        $exists = Mina2MrpCtrlr::where('WRK_CNTR', $validated['WRK_CNTR'])
            ->where('WRK_CNTR', '!=', $wrk_cntr)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'WRK_CNTR sudah digunakan!'
            ], 422);
        }

        $row = Mina2MrpCtrlr::where('WRK_CNTR', $wrk_cntr)->firstOrFail();
        $row->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui.'
        ]);
    }

    public function destroy($wrk_cntr)
    {
        Mina2MrpCtrlr::where('WRK_CNTR', $wrk_cntr)->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            Excel::import(new Mina2MrpCtrlrImport, $request->file('file'));
            return response()->json(['success' => true, 'message' => 'Import berhasil!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Import gagal: '.$e->getMessage()], 422);
        }
    }
}
