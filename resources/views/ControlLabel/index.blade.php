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
        <!-- Card summary status di atas tabel -->
        <div class="d-flex flex-row flex-wrap align-items-center gap-2 mb-3" id="status-summary-cards" style="min-height:48px;">
            <!-- Card summary akan diisi via JS -->
        </div>
        <div class="card">
            <div class="card-header px-3 py-2 d-flex justify-content-end">
                <a class="modal-effect btn btn-success-light" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modalImportExcel">
                    Upload Excel <i class="fa fa-upload"></i>
                </a>
            </div>
            <div class="card-body">
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

<!-- Modal Import Excel -->
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
const statusList = [
    {key: 'Open', label: 'Open', color: 'success', icon: 'fa-check-circle'},
    {key: 'Close', label: 'Close', color: 'dark', icon: 'fa-lock'},
    {key: 'Deleted', label: 'Deleted', color: 'secondary', icon: 'fa-trash'},
    {key: 'Delay', label: 'Delay', color: 'warning text-dark', icon: 'fa-hourglass-end'},
    {key: 'Next Delay', label: 'Next Delay', color: 'info text-dark', icon: 'fa-hourglass-half'},
    {key: 'Cost Error', label: 'Cost Error', color: 'danger', icon: 'fa-exclamation-triangle'}
];

function renderStatusCards(selectedStatus = '') {
    $.get("{{ route('mina2coois.statusSummary') }}", function(data) {
        let html = '';
        statusList.forEach(st => {
            let active = (selectedStatus === st.key) ? 'border-3 border-primary shadow' : '';
            html += `
                <div class="card card-status-summary ${active}" style="min-width:100px; cursor:pointer;" data-status="${st.key}">
                    <div class="card-body py-2 px-2 text-center">
                        <div class="mb-1">
                            <span class="badge bg-${st.color} fs-5" data-bs-toggle="tooltip" title="${st.label}">
                                <i class="fa ${st.icon}"></i>
                            </span>
                        </div>
                        <div class="fw-bold">${st.label}</div>
                        <div class="fs-4" id="count-${st.key.replace(' ', '-')}">${data[st.key]}</div>
                    </div>
                </div>
            `;
        });
        $('#status-summary-cards').html(html);

        // Inisialisasi ulang tooltip Bootstrap setelah render
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            if (tooltipTriggerEl._tooltip) {
                tooltipTriggerEl._tooltip.dispose();
            }
            tooltipTriggerEl._tooltip = new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
}

var table;
$(document).ready(function() {
    let selectedStatus = '';

    // Inisialisasi DataTables
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
            { 
                data: 'SYS_STATUS',
                name: 'SYS_STATUS',
                render: function(data) {
                    if (!data) return '';
                    let badgeClass = '';
                    let icon = '';
                    let tooltip = '';
                    let label = data;
                    switch (data) {
                        case 'Open':
                            badgeClass = 'badge bg-success';
                            icon = '<i class="fa fa-check-circle"></i> ';
                            tooltip = 'Label/Order masih aktif dan dapat digunakan.';
                            break;
                        case 'Close':
                            badgeClass = 'badge bg-dark';
                            icon = '<i class="fa fa-lock"></i> ';
                            tooltip = 'Label/Order telah ditutup dan tidak dapat digunakan lagi.';
                            break;
                        case 'Deleted':
                            badgeClass = 'badge bg-secondary';
                            icon = '<i class="fa fa-trash"></i> ';
                            tooltip = 'Label/Order telah dihapus, baik sudah digunakan maupun belum.';
                            break;
                        case 'Delay':
                            badgeClass = 'badge bg-warning text-dark';
                            icon = '<i class="fa fa-hourglass-end"></i> ';
                            tooltip = 'Label/Order telah melewati masa berlaku dan harus segera dikembalikan.';
                            break;
                        case 'Next Delay':
                            badgeClass = 'badge bg-info text-dark';
                            icon = '<i class="fa fa-hourglass-half"></i> ';
                            tooltip = 'Label/Order akan memasuki status delay pada hari berikutnya.';
                            break;
                        case 'Cost Error':
                            badgeClass = 'badge bg-danger';
                            icon = '<i class="fa fa-exclamation-triangle"></i> ';
                            tooltip = 'Label/Order mengalami kesalahan perhitungan biaya dan tidak boleh digunakan. Harap dikembalikan ke bagian PPC.';
                            break;
                        default:
                            badgeClass = 'badge bg-light text-dark';
                            icon = '<i class="fa fa-question"></i> ';
                            tooltip = 'Status tidak diketahui.';
                    }
                    return `<span class="${badgeClass}" data-bs-toggle="tooltip" title="${tooltip}">${icon}${label}</span>`;
                }
            },
            { data: 'CHG_BY', name: 'CHG_BY' },
            { 
                data: 'CHG_TIME', 
                name: 'CHG_TIME',
                render: function(data) {
                    if (!data) return '';
                    let time = data.toString().substring(0, 8);
                    let [h, m, s] = time.split(':');
                    h = parseInt(h);
                    let ampm = h >= 12 ? 'PM' : 'AM';
                    let hour12 = h % 12 || 12;
                    return `${hour12}:${m} ${ampm}`;
                }
            },
            { 
                data: 'CRT_TIME', 
                name: 'CRT_TIME',
                render: function(data) {
                    if (!data) return '';
                    let time = data.toString().substring(0, 8);
                    let [h, m, s] = time.split(':');
                    h = parseInt(h);
                    let ampm = h >= 12 ? 'PM' : 'AM';
                    let hour12 = h % 12 || 12;
                    return `${hour12}:${m} ${ampm}`;
                }
            },
            { data: 'BSC_START', name: 'BSC_START' },
            { data: 'BSC_FINISH', name: 'BSC_FINISH' },
            { data: 'ORD_QTY', name: 'ORD_QTY' },
            { data: 'ACT_PROD', name: 'ACT_PROD' },
            { data: 'UNIT', name: 'UNIT' },
            { data: 'CRT_DATE', name: 'CRT_DATE' },
            { data: 'CHG_DATE', name: 'CHG_DATE' },
        ]
    });

    // Render summary cards
    renderStatusCards();

    // Klik card untuk filter (tanpa regex agar support SQL Server)
    $(document).on('click', '.card-status-summary', function() {
        let status = $(this).data('status');
        if (selectedStatus === status) {
            selectedStatus = '';
            table.column(5).search('').draw();
        } else {
            selectedStatus = status;
            table.column(5).search(status, false, false).draw(); // regex: false
        }
        renderStatusCards(selectedStatus);
    });

    // Validasi file import
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
        }).then(() => {
            table.ajax.reload();
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

    table.on('draw.dt', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            if (tooltipTriggerEl._tooltip) {
                tooltipTriggerEl._tooltip.dispose();
            }
            tooltipTriggerEl._tooltip = new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
});
</script>
<style>
    #status-summary-cards {
        gap: 0.5rem !important;
    }
    .card-status-summary {
        min-width: 90px !important;
        max-width: 100px;
        padding: 0;
        margin: 0;
        border-radius: 0.5rem;
        border-width: 2px;
        box-shadow: none;
        transition: border 0.2s, box-shadow 0.2s;
        background: #f8f9fa;
    }
    .card-status-summary .card-body {
        padding: 0.4rem 0.3rem !important;
    }
    .card-status-summary .fs-4 {
        font-size: 1rem !important;
        margin-bottom: 0;
    }
    .card-status-summary .fw-bold {
        font-size: 0.85rem !important;
        margin-bottom: 0;
    }
    .card-status-summary .badge {
        font-size: 1rem !important;
        padding: 0.3em 0.6em;
    }
    @media (max-width: 600px) {
        .card-status-summary {
            min-width: 80px !important;
            max-width: 90px;
        }
        .card-header .btn {
            margin-top: 0.5rem;
        }
    }
</style>
@endsection