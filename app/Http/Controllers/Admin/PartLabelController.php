<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Excel; // Untuk maatwebsite/excel v1.x

class PartLabelController extends Controller
{
    public function index()
    {
        $title = 'Master Part Label';
        return view('Admin.MasterLabel.index', compact('title'));
    }

    public function getdata(Request $request)
    {
        $data = DB::table('ms_part_label')->get()->map(function($row) {
            $row->ZZP_NUM_ENT = round($row->ZZP_NUM_ENT, 2);
            return $row;
        });
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $id = $row->MATNR;
                $name = $row->MAKTX;
                return '
                    <button class="btn btn-sm btn-warning" onclick="editPartLabel('.htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8').')"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="hapusPartLabel(\''.$id.'\', \''.addslashes($name).'\')"><i class="fa fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'WERKS' => 'required|string|max:10',
            'MATNR' => 'required|string|max:18|unique:ms_part_label,MATNR',
            'MAKTX' => 'required|string|max:100',
            'ARBPL' => 'nullable|string|max:20',
            'VORNR' => 'nullable|string|max:10',
            'EXTWG' => 'nullable|string|max:10',
            'LTXA1W' => 'nullable|string|max:100',
            'ZZP_NUM_ENT' => 'nullable|numeric',
            'BUN' => 'nullable|string|max:5',
            'MRP' => 'nullable|string|max:10',
            'PLANT' => 'nullable|string|max:10',
            'LNNM' => 'nullable|string|max:50',
            'VSBL' => 'nullable|string|max:1',
        ]);
        try {
            \DB::table('ms_part_label')->insert($validated);
            return response()->json(['status' => 'success', 'msg' => 'Data berhasil ditambah']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal tambah data: '.$e->getMessage()], 500);
        }
    }

    public function update(Request $request, $matnr)
    {
        $validated = $request->validate([
            'WERKS' => 'required|string|max:10',
            'MATNR' => 'required|string|max:18',
            'MAKTX' => 'required|string|max:100',
            'ARBPL' => 'nullable|string|max:20',
            'VORNR' => 'nullable|string|max:10',
            'EXTWG' => 'nullable|string|max:10',
            'LTXA1W' => 'nullable|string|max:100',
            'ZZP_NUM_ENT' => 'nullable|numeric',
            'BUN' => 'nullable|string|max:5',
            'MRP' => 'nullable|string|max:10',
            'PLANT' => 'nullable|string|max:10',
            'LNNM' => 'nullable|string|max:50',
            'VSBL' => 'nullable|string|max:1',
        ]);
        try {
            \DB::table('ms_part_label')->where('MATNR', $matnr)->update($validated);
            return response()->json(['status' => 'success', 'msg' => 'Data berhasil diupdate']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal update data: '.$e->getMessage()], 500);
        }
    }

    public function destroy($matnr)
    {
        DB::table('ms_part_label')->where('MATNR', $matnr)->delete();
        return response()->json(['status' => 'success', 'msg' => 'Data berhasil dihapus']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $import = new \App\Imports\PartLabelImport;
            \Maatwebsite\Excel\Facades\Excel::import($import, $request->file('file'));
            $count = $import->getSuccessCount() ?? 0;
            return back()->with('import_result', [
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return back()->with('import_result', [
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}