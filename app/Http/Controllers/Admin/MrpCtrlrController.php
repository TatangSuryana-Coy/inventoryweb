<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Mina2MrpCtrlr;

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
                $del = "<a href='javascript:void(0)' class='btn btn-sm btn-danger' onclick='deleteData(".json_encode($row).")'>Hapus</a>";
                return $edit . " " . $del;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'MRP_CTRL' => 'required|max:4',
            'WRK_CNTR' => 'required|max:7',
            'MRP_NAME' => 'required|max:30',
            'PLANT' => 'required|max:5',
        ]);
        Mina2MrpCtrlr::create($request->all());
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $mrp_ctrl, $wrk_cntr)
    {
        $row = Mina2MrpCtrlr::where('MRP_CTRL', $mrp_ctrl)->where('WRK_CNTR', $wrk_cntr)->firstOrFail();
        $row->update($request->all());
        return response()->json(['success' => true]);
    }

    public function destroy($mrp_ctrl, $wrk_cntr)
    {
        Mina2MrpCtrlr::where('MRP_CTRL', $mrp_ctrl)->where('WRK_CNTR', $wrk_cntr)->delete();
        return response()->json(['success' => true]);
    }
}