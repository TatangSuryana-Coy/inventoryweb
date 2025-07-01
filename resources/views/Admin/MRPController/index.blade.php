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
                <div>
                    <button class="modal-effect btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        Tambah Data
                    </button>
                    <button class="modal-effect btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
                        Upload Excel <i class="fa fa-upload"></i>
                    </button>
                </div>
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
@include('Admin.MRPController.import')
@endsection

@section('scripts')
<script>
$(function(){
    // Setup CSRF token AJAX
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // DataTables
    var table = $('#table-mrpctrlr').DataTable({
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

    // Tambah Data
    $('#formTambah').submit(function(e){
        e.preventDefault();
        $('#errorTambah').addClass('d-none').html('');
        $.post("{{ route('mrpctrlr.store') }}", $(this).serialize(), function(){
            $('#modalTambah').modal('hide');
            table.ajax.reload();
            $('#formTambah')[0].reset();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil ditambahkan!',
                timer: 1500,
                showConfirmButton: false
            });
        }).fail(function(xhr){
            let msg = 'Terjadi kesalahan!';
            if(xhr.responseJSON && xhr.responseJSON.errors){
                msg = Object.values(xhr.responseJSON.errors).join('<br>');
            } else if(xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            $('#errorTambah').removeClass('d-none').html(msg);
        });
    });

    // Edit Data
    window.editData = function(row){
        // Reset error setiap kali modal edit dibuka
        $('#errorEdit').addClass('d-none').html('');
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
        $('#errorEdit').addClass('d-none').html('');
        var oldWrk = $('#modalEdit input[name="WRK_CNTR_OLD"]').val();
        $.post("{{ url('admin/mrp-ctrlr/update') }}/"+oldWrk, $(this).serialize(), function(){
            $('#modalEdit').modal('hide');
            table.ajax.reload();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil diubah!',
                timer: 1500,
                showConfirmButton: false
            });
        }).fail(function(xhr){
            let msg = 'Terjadi kesalahan!';
            if(xhr.responseJSON && xhr.responseJSON.errors){
                msg = Object.values(xhr.responseJSON.errors).join('<br>');
            } else if(xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            $('#errorEdit').removeClass('d-none').html(msg);
        });
    });

    // Reset error saat input berubah di modal edit
    $('#modalEdit input').on('input', function() {
        $('#errorEdit').addClass('d-none').html('');
    });

    // Hapus Data
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
        var wrk = $('#formHapus input[name="WRK_CNTR_HAPUS"]').val();
        $.post("{{ url('admin/mrp-ctrlr/destroy') }}/"+wrk, function(){
            $('#modalHapus').modal('hide');
            table.ajax.reload();
        }).fail(function(xhr){
            alert('Error: ' + xhr.responseText);
        });
    });

    // Import Excel
    $('#formImport').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        var fileInput = $(this).find('input[type="file"]')[0];
        var filePath = fileInput.value;
        var allowedExtensions = /(\.xls|\.xlsx)$/i;
        if(!allowedExtensions.exec(filePath)){
            $('#errorImport').removeClass('d-none').html('Hanya file Excel (.xls, .xlsx) yang diperbolehkan!');
            fileInput.value = '';
            return false;
        }
        $('#errorImport').addClass('d-none').html('');
        $('#btnImport .spinner-border').removeClass('d-none');
        $('#btnImport').attr('disabled', true);

        $.ajax({
            url: "{{ route('mrpctrlr.import') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                $('#modalImportExcel').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message || 'Import berhasil!',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#formImport')[0].reset();
            },
            error: function(xhr){
                let msg = 'Import gagal!';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                $('#errorImport').removeClass('d-none').html(msg);
            },
            complete: function(){
                $('#btnImport .spinner-border').addClass('d-none');
                $('#btnImport').attr('disabled', false);
            }
        });
    });
});
</script>
@endsection
