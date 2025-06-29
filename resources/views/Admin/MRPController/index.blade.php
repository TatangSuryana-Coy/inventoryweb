@extends('Master.Layouts.app', ['title' => $title])

@section('content')
<div class="page-header">
    <h1 class="page-title">MRP Controller</h1>
</div>
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3 class="card-title">Data</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-mrpctrlr" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>MRP_CTRL</th>
                                <th>WRK_CNTR</th>
                                <th>MRP_NAME</th>
                                <th>PLANT</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Admin.MRPController.tambah')
@include('Admin.MRPController.edit')
@include('Admin.MRPController.hapus')
@endsection

@section('scripts')
<script>
var table;
$(function(){
    table = $('#table-mrpctrlr').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('mrpctrlr.data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'MRP_CTRL', name: 'MRP_CTRL' },
            { data: 'WRK_CNTR', name: 'WRK_CNTR' },
            { data: 'MRP_NAME', name: 'MRP_NAME' },
            { data: 'PLANT', name: 'PLANT' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Tambah
    $('#formTambah').submit(function(e){
        e.preventDefault();
        $.post("{{ route('mrpctrlr.store') }}", $(this).serialize(), function(){
            $('#modalTambah').modal('hide');
            table.ajax.reload();
            $('#formTambah')[0].reset();
        });
    });

    // Edit
    window.editData = function(row){
        $('#modalEdit input[name="MRP_CTRL_OLD"]').val(row.MRP_CTRL);
        $('#modalEdit input[name="WRK_CNTR_OLD"]').val(row.WRK_CNTR);
        $('#modalEdit input[name="MRP_CTRL"]').val(row.MRP_CTRL);
        $('#modalEdit input[name="WRK_CNTR"]').val(row.WRK_CNTR);
        $('#modalEdit input[name="MRP_NAME"]').val(row.MRP_NAME);
        $('#modalEdit input[name="PLANT"]').val(row.PLANT);
        $('#modalEdit').modal('show');
    };

    $('#formEdit').submit(function(e){
        e.preventDefault();
        var oldCtrl = $('#modalEdit input[name="MRP_CTRL_OLD"]').val();
        var oldWrk = $('#modalEdit input[name="WRK_CNTR_OLD"]').val();
        $.post("{{ url('admin/mrp-ctrlr/update') }}/"+oldCtrl+"/"+oldWrk, $(this).serialize(), function(){
            $('#modalEdit').modal('hide');
            table.ajax.reload();
        });
    });

    // Hapus
    window.deleteData = function(row){
        $('#formHapus input[name="MRP_CTRL_HAPUS"]').val(row.MRP_CTRL);
        $('#formHapus input[name="WRK_CNTR_HAPUS"]').val(row.WRK_CNTR);
        $('#infoHapus').html(
            `<b>MRP_CTRL:</b> ${row.MRP_CTRL}<br>
             <b>WRK_CNTR:</b> ${row.WRK_CNTR}<br>
             <b>MRP_NAME:</b> ${row.MRP_NAME}<br>
             <b>PLANT:</b> ${row.PLANT}`
        );
        $('#modalHapus').modal('show');
    };

    $('#formHapus').submit(function(e){
        e.preventDefault();
        var mrp = $('#formHapus input[name="MRP_CTRL_HAPUS"]').val();
        var wrk = $('#formHapus input[name="WRK_CNTR_HAPUS"]').val();
        $.post("{{ url('admin/mrp-ctrlr/destroy') }}/"+mrp+"/"+wrk, {_token: "{{ csrf_token() }}"}, function(){
            $('#modalHapus').modal('hide');
            table.ajax.reload();
        });
    });
});
</script>
@endsection