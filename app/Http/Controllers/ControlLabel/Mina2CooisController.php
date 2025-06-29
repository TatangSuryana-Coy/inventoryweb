<?php

namespace App\Http\Controllers\ControlLabel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\Mina2CooisImport;
use Maatwebsite\Excel\Facades\Excel;

class Mina2CooisController extends Controller
{
    public function index()
    {
        // Contoh: Ambil nama plant pertama sebagai title
        $title = DB::table('mina2_coois')->value('PLANT') ?? 'Data Label';
        return view('ControlLabel.index', compact('title'));
    }

    public function data(Request $request)
    {
        $query = DB::table('mina2_coois');
        return datatables()->of($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $import = new Mina2CooisImport();
            Excel::import($import, $request->file('file'));
            return redirect()->back()->with('success', 'Import berhasil. Jumlah baris: ' . $import->getSuccessCount());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
    public function statusSummary()
    {
        $statuses = [
            'Open', 'Close', 'Deleted', 'Delay', 'Next Delay', 'Cost Error'
        ];
        $counts = DB::table('mina2_coois')
            ->selectRaw("SYS_STATUS, COUNT(*) as total")
            ->whereIn('SYS_STATUS', $statuses)
            ->groupBy('SYS_STATUS')
            ->pluck('total', 'SYS_STATUS')
            ->toArray();

        // Pastikan semua status ada, meski 0
        $result = [];
        foreach ($statuses as $status) {
            $result[$status] = $counts[$status] ?? 0;
        }
        return response()->json($result);
    }
}