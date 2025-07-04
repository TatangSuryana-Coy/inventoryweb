@extends('Master.Layouts.app', ['title' => $title])

@section('content')
<div class="page-header">
    <h1 class="page-title">{{$title}}</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-gray">Master Data</li>
            <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
        </ol>
    </div>
</div>

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3 class="card-title">Data</h3>
                <div>
                    <a class="modal-effect btn btn-primary" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modalTambah">
                        <i class="fa fa-plus"></i> Tambah Data
                    </a>
                    <a class="modal-effect btn btn-success" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modalImportExcel">
                        <i class="fa fa-upload"></i> Upload Excel
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-partlabel" class="table table-bordered text-nowrap border-bottom dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>WERKS</th>
                                <th>MATNR</th>
                                <th>MAKTX</th>
                                <th>ARBPL</th>
                                <th>VORNR</th>
                                <th>EXTWG</th>
                                <th>LTXA1W</th>
                                <th>ZZP_NUM_ENT</th>
                                <th>BUN</th>
                                <th>MRP</th>
                                <th>PLANT</th>
                                <th>LNNM</th>
                                <th>VSBL</th>
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

@include('Admin.MasterLabel.tambah')
@include('Admin.MasterLabel.edit')
@include('Admin.MasterLabel.hapus')
@include('Admin.MasterLabel.import')

<!-- Modal Upload Excel -->
<div class="modal fade" id="modalImportExcel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('MasterLabel.import') }}" method="POST" enctype="multipart/form-data" id="formImport">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="file" name="file" class="form-control mb-2" accept=".xls,.xlsx" required>
                    <div id="errorImport" class="alert alert-danger d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnImport">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="fa fa-upload"></i> Import Excel
                    </button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var table;
    $(document).ready(function() {
        table = $('#table-partlabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('MasterLabel.getdata') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'WERKS',
                    name: 'WERKS'
                },
                {
                    data: 'MATNR',
                    name: 'MATNR'
                },
                {
                    data: 'MAKTX',
                    name: 'MAKTX'
                },
                {
                    data: 'ARBPL',
                    name: 'ARBPL'
                },
                {
                    data: 'VORNR',
                    name: 'VORNR'
                },
                {
                    data: 'EXTWG',
                    name: 'EXTWG'
                },
                {
                    data: 'LTXA1W',
                    name: 'LTXA1W'
                },
                {
                    data: 'ZZP_NUM_ENT',
                    name: 'ZZP_NUM_ENT',
                    render: function(data) {
                        if (data == null) return '';
                        return parseFloat(data).toLocaleString('en-US', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 2
                        });
                    }
                },
                {
                    data: 'BUN',
                    name: 'BUN'
                },
                {
                    data: 'MRP',
                    name: 'MRP'
                },
                {
                    data: 'PLANT',
                    name: 'PLANT'
                },
                {
                    data: 'LNNM',
                    name: 'LNNM'
                },
                {
                    data: 'VSBL',
                    name: 'VSBL'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // Submit tambah
        $('#formTambah').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var btn = $('#btnSimpanTambah');
            var spinner = btn.find('.spinner-border');
            btn.attr('disabled', true);
            spinner.removeClass('d-none');
            $('#errorTambah').addClass('d-none').html('');
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(res) {
                    btn.attr('disabled', false);
                    spinner.addClass('d-none');
                    if (res.status === 'success') {
                        $('#modalTambah').modal('hide');
                        table.ajax.reload();
                        form[0].reset();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.msg
                        });
                    } else {
                        $('#errorTambah').removeClass('d-none').html(res.msg || 'Gagal tambah data');
                    }
                },
                error: function(xhr) {
                    btn.attr('disabled', false);
                    spinner.addClass('d-none');
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        let pesan = '';
                        $.each(xhr.responseJSON.errors, function(key, val) {
                            pesan += val[0] + '<br>';
                        });
                        $('#errorTambah').removeClass('d-none').html(pesan);
                    } else {
                        $('#errorTambah').removeClass('d-none').html(xhr.responseJSON?.message || 'Gagal tambah data');
                    }
                }
            });
        });

        // Submit edit
        $('#formEdit').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var btn = $('#btnSimpanEdit');
            var spinner = btn.find('.spinner-border');
            var matnr = form.find('[name="MATNR"]').val();
            btn.attr('disabled', true);
            spinner.removeClass('d-none');
            $('#errorEdit').addClass('d-none').html('');
            $.ajax({
                url: "{{ url('admin/ms-label/update') }}/" + matnr,
                method: 'PUT',
                data: form.serialize(),
                success: function(res) {
                    btn.attr('disabled', false);
                    spinner.addClass('d-none');
                    if (res.status === 'success') {
                        $('#modalEdit').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.msg
                        });
                    } else {
                        $('#errorEdit').removeClass('d-none').html(res.msg || 'Gagal update data');
                    }
                },
                error: function(xhr) {
                    btn.attr('disabled', false);
                    spinner.addClass('d-none');
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        let pesan = '';
                        $.each(xhr.responseJSON.errors, function(key, val) {
                            pesan += val[0] + '<br>';
                        });
                        $('#errorEdit').removeClass('d-none').html(pesan);
                    } else {
                        $('#errorEdit').removeClass('d-none').html(xhr.responseJSON?.message || 'Gagal update data');
                    }
                }
            });
        });

        // Submit hapus
        $('#btnHapus').click(function() {
            var id = $('#idHapus').val();
            $.ajax({
                url: "{{ url('admin/ms-label/destroy') }}/" + id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status === 'success') {
                        $('#modalHapus').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.msg
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.msg
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON?.message || 'Gagal hapus data'
                    });
                }
            });
        });

        // Validasi form import
        $('#formImport').submit(function(e) {
            var fileInput = $(this).find('input[type="file"]')[0];
            var filePath = fileInput.value;
            var allowedExtensions = /(\.xls|\.xlsx)$/i;
            if (!allowedExtensions.exec(filePath)) {
                $('#errorImport').removeClass('d-none').html('Hanya file Excel (.xls, .xlsx) yang diperbolehkan!');
                fileInput.value = '';
                e.preventDefault();
                return false;
            }
            $('#errorImport').addClass('d-none').html('');
        });
    });

    // Isi modal edit
    function editPartLabel(data) {
        var form = $('#formEdit');
        $('#errorEdit').addClass('d-none').html('');
        for (const key in data) {
            form.find('[name="' + key + '"]').val(data[key]);
        }
        $('#modalEdit').modal('show');
    }

    // Isi modal hapus
    function hapusPartLabel(id, name) {
        $('#idHapus').val(id);
        $('#infoHapus').html('<b>' + id + '</b> - <b>' + name + '</b>');
        $('#modalHapus').modal('show');
    }
</script>

@if(session('import_result'))
<script>
    $(document).ready(function() {
        @if(session('import_result.success'))
        Swal.fire({
            icon: 'success',
            title: 'Import Berhasil!',
            text: "Jumlah baris berhasil diimport: {{ session('import_result.count') }}"
        });
        @else
        Swal.fire({
            icon: 'error',
            title: 'Import Gagal!',
            text: '{{ session('
            import_result.message ') }}'
        });
        @endif
    });
</script>
@endif
@endsection