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
        $data = Mina2MrpCtrlr::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $edit = "<a href='javascript:void(0)' class='btn btn-sm btn-primary' onclick='editData(".json_encode($row).")'>Edit</a>";
                $del  = "<a href='javascript:void(0)' class='btn btn-sm btn-danger' onclick='deleteData(".json_encode($row).")'>Hapus</a>";
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

        Mina2MrpCtrlr::create($validated);

        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan.']);
    }

    public function update(Request $request, $mrp_ctrl, $wrk_cntr)
    {
        $validated = $request->validate([
            'MRP_CTRL' => 'required|max:4',
            'WRK_CNTR' => 'required|max:7',
            'MRP_NAME' => 'required|max:30',
            'PLANT'    => 'required|max:5',
        ]);

        // Cek apakah kombinasi baru sudah ada (selain data yang sedang diedit)
        $exists = Mina2MrpCtrlr::where('MRP_CTRL', $validated['MRP_CTRL'])
            ->where('WRK_CNTR', $validated['WRK_CNTR'])
            ->where(function($q) use ($mrp_ctrl, $wrk_cntr) {
                $q->where('MRP_CTRL', '!=', $mrp_ctrl)
                  ->orWhere('WRK_CNTR', '!=', $wrk_cntr);
            })
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Kombinasi MRP_CTRL dan WRK_CNTR sudah digunakan!'], 422);
        }

        $row = Mina2MrpCtrlr::where('MRP_CTRL', $mrp_ctrl)
                ->where('WRK_CNTR', $wrk_cntr)
                ->firstOrFail();

        // Update semua field, termasuk jika primary key berubah
        $row->update($validated);

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
    }

    public function destroy($mrp_ctrl, $wrk_cntr)
    {
        Mina2MrpCtrlr::where('MRP_CTRL', $mrp_ctrl)
            ->where('WRK_CNTR', $wrk_cntr)
            ->delete();

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
