@extends('Master.Layouts.app', ['title' => $title])

@section('content')
<div class="page-header">
    <h1 class="page-title">WorkDay</h1>
</div>
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3 class="card-title">Data</h3>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImportExcel">Upload Excel</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-workday" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>WorkDate</th>
                                <th>StatusDay</th>
                                <th>NoteDay</th>
                                <th>StatusLabel</th>
                                <th>EXPDT</th>
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

@include('Admin.WorkDay.tambah')
@include('Admin.WorkDay.edit')
@include('Admin.WorkDay.hapus')
@include('Admin.WorkDay.import')
@endsection

@section('scripts')
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#table-workday').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('workday.data') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'WorkDate',
                    name: 'WorkDate'
                },
                {
                    data: 'StatusDay',
                    name: 'StatusDay'
                },
                {
                    data: 'NoteDay',
                    name: 'NoteDay'
                },
                {
                    data: 'StatusLabel',
                    name: 'StatusLabel'
                },
                {
                    data: 'EXPDT',
                    name: 'EXPDT'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Tambah Data
        $('#formTambah').submit(function(e) {
            e.preventDefault();
            $('#errorTambah').addClass('d-none').html('');
            $.post("{{ route('workday.store') }}", $(this).serialize(), function() {
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
            }).fail(function(xhr) {
                let msg = 'Terjadi kesalahan!';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                $('#errorTambah').removeClass('d-none').html(msg);
            });
        });

        // Edit Data
        window.editData = function(row) {
            $('#errorEdit').addClass('d-none').html('');
            $('#modalEdit input[name="WorkDate_OLD"]').val(row.WorkDate);
            $('#modalEdit input[name="WorkDate"]').val(row.WorkDate);
            $('#modalEdit select[name="StatusDay"]').val(row.StatusDay);
            $('#modalEdit input[name="NoteDay"]').val(row.NoteDay);
            $('#modalEdit input[name="StatusLabel"]').val(row.StatusLabel);
            $('#modalEdit input[name="EXPDT"]').val(row.EXPDT);
            $('#modalEdit').modal('show');
        };

        $('#formEdit').submit(function(e) {
            e.preventDefault();
            $('#errorEdit').addClass('d-none').html('');
            var oldDate = $('#modalEdit input[name="WorkDate_OLD"]').val();
            $.post("{{ url('admin/workday/update') }}/" + oldDate, $(this).serialize(), function() {
                $('#modalEdit').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil diubah!',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).fail(function(xhr) {
                let msg = 'Terjadi kesalahan!';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                $('#errorEdit').removeClass('d-none').html(msg);
            });
        });

        // Reset error saat input berubah di modal edit
        $(document).on('input', '#modalEdit input', function() {
            $('#errorEdit').addClass('d-none').html('');
        });

        // Hapus Data
        window.deleteData = function(row) {
            $('#formHapus input[name="WorkDate_HAPUS"]').val(row.WorkDate);
            $('#infoHapus').html(
                `<b>WorkDate:</b> ${row.WorkDate}<br>
             <b>StatusDay:</b> ${row.StatusDay}<br>
             <b>NoteDay:</b> ${row.NoteDay}<br>
             <b>StatusLabel:</b> ${row.StatusLabel}<br>
             <b>EXPDT:</b> ${row.EXPDT}`
            );
            $('#modalHapus').modal('show');
        };

        $('#formHapus').submit(function(e) {
            e.preventDefault();
            var workdate = $('#formHapus input[name="WorkDate_HAPUS"]').val();
            $.post("{{ url('admin/workday/destroy') }}/" + workdate, function() {
                $('#modalHapus').modal('hide');
                table.ajax.reload();
            }).fail(function(xhr) {
                alert('Error: ' + xhr.responseText);
            });
        });

        // Import Excel
        $('#formImport').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var fileInput = $(this).find('input[type="file"]')[0];
            var filePath = fileInput.value;
            var allowedExtensions = /(\.xls|\.xlsx)$/i;
            if (!allowedExtensions.exec(filePath)) {
                $('#errorImport').removeClass('d-none').html('Hanya file Excel (.xls, .xlsx) yang diperbolehkan!');
                fileInput.value = '';
                return false;
            }
            $('#errorImport').addClass('d-none').html('');
            $('#btnImport .spinner-border').removeClass('d-none');
            $('#btnImport').attr('disabled', true);

            $.ajax({
                url: "{{ route('workday.import') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
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
                error: function(xhr) {
                    let msg = 'Import gagal!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    $('#errorImport').removeClass('d-none').html(msg);
                },
                complete: function() {
                    $('#btnImport .spinner-border').addClass('d-none');
                    $('#btnImport').attr('disabled', false);
                }
            });
        });
    });
</script>
@endsection