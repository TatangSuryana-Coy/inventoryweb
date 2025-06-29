@extends('Master.Layouts.app', ['title' => $title])

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $title }}</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-gray">Master Data</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </div>
</div>

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3 class="card-title">Data</h3>
                <div>
                    {{-- Contoh tombol, bisa tambahkan fitur import jika perlu --}}
                    <a class="modal-effect btn btn-success-light" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modalImportExcel">
                        Upload Excel <i class="fa fa-upload"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table id="table-coois" class="table table-bordered text-nowrap border-bottom dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>MRP</th>
                                <th>MAT_NUMBER</th>
                                <th>MAT_DESCRIPTION</th>
                                <th>PROD_ORDER</th>
                                <th>SYS_STATUS</th>
                                <th>CHG_BY</th>
                                <th>CHG_TIME</th>
                                <th>CRT_TIME</th>
                                <th>BSC_START</th>
                                <th>BSC_FINISH</th>
                                <th>ORD_QTY</th>
                                <th>ACT_PROD</th>
                                <th>UNIT</th>
                                <th>CRT_DATE</th>
                                <th>CHG_DATE</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalImportExcel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('mina2coois.import') }}" method="POST" enctype="multipart/form-data" id="formImport">
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
                        Import Excel
                    </button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
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
        table = $('#table-coois').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('mina2coois.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'MRP', name: 'MRP' },
                { data: 'MAT_NUMBER', name: 'MAT_NUMBER' },
                { data: 'MAT_DESCRIPTION', name: 'MAT_DESCRIPTION' },
                { data: 'PROD_ORDER', name: 'PROD_ORDER' },
                { data: 'SYS_STATUS', name: 'SYS_STATUS' },
                { data: 'CHG_BY', name: 'CHG_BY' },
                { data: 'CHG_TIME', name: 'CHG_TIME' },
                { data: 'CRT_TIME', name: 'CRT_TIME' },
                { data: 'BSC_START', name: 'BSC_START' },
                { data: 'BSC_FINISH', name: 'BSC_FINISH' },
                { data: 'ORD_QTY', name: 'ORD_QTY' },
                { data: 'ACT_PROD', name: 'ACT_PROD' },
                { data: 'UNIT', name: 'UNIT' },
                { data: 'CRT_DATE', name: 'CRT_DATE' },
                { data: 'CHG_DATE', name: 'CHG_DATE' },
            ]
        });
    });

    $('#formImport').submit(function(e){
        var fileInput = $(this).find('input[type="file"]')[0];
        var filePath = fileInput.value;
        var allowedExtensions = /(\.xls|\.xlsx)$/i;
        if(!allowedExtensions.exec(filePath)){
            $('#errorImport').removeClass('d-none').html('Hanya file Excel (.xls, .xlsx) yang diperbolehkan!');
            fileInput.value = '';
            e.preventDefault();
            return false;
        }
        $('#errorImport').addClass('d-none').html('');
    });

    // SweetAlert notification
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('error') }}',
            timer: 3500,
            showConfirmButton: true
        });
    @endif
</script>
@endsection