<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    BarangController,
    BarangkeluarController,
    BarangmasukController,
    CustomerController,
    DashboardController,
    JenisBarangController,
    LapBarangKeluarController,
    LapBarangMasukController,
    LapStokBarangController,
    LoginController,
    MerkController,
    SatuanController,
    PartLabelController
};
use App\Http\Controllers\Master\{
    AksesController,
    AppreanceController,
    MenuController,
    RoleController,
    UserController,
    WebController
};
use App\Http\Controllers\ControlLabel\Mina2CooisController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Login admin
Route::middleware(['preventBackHistory'])->group(function () {
    Route::get('/admin/login', [LoginController::class, 'index'])->middleware('useractive');
    Route::post('/admin/proseslogin', [LoginController::class, 'proseslogin'])->middleware('useractive');
    Route::get('/admin/logout', [LoginController::class, 'logout']);
});

// Admin area
Route::middleware(['userlogin'])->group(function () {

    // Profile & Appreance
    Route::get('/admin/profile/{user}', [UserController::class, 'profile']);
    Route::post('/admin/updatePassword/{user}', [UserController::class, 'updatePassword']);
    Route::post('/admin/updateProfile/{user}', [UserController::class, 'updateProfile']);
    Route::get('/admin/appreance/', [AppreanceController::class, 'index']);
    Route::post('/admin/appreance/{setting}', [AppreanceController::class, 'update']);

    // Dashboard
    Route::middleware(['checkRoleUser:/dashboard,menu'])->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/admin', [DashboardController::class, 'index']);
        Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    });

    // Jenis Barang
    Route::middleware(['checkRoleUser:/jenisbarang,submenu'])->group(function () {
        Route::get('/admin/jenisbarang', [JenisBarangController::class, 'index']);
        Route::get('/admin/jenisbarang/show/', [JenisBarangController::class, 'show'])->name('jenisbarang.getjenisbarang');
        Route::post('/admin/jenisbarang/proses_tambah/', [JenisBarangController::class, 'proses_tambah'])->name('jenisbarang.store');
        Route::post('/admin/jenisbarang/proses_ubah/{jenisbarang}', [JenisBarangController::class, 'proses_ubah']);
        Route::post('/admin/jenisbarang/proses_hapus/{jenisbarang}', [JenisBarangController::class, 'proses_hapus']);
    });

    // Satuan
    Route::middleware(['checkRoleUser:/satuan,submenu'])->group(function () {
        Route::resource('/admin/satuan', SatuanController::class);
        Route::get('/admin/satuan/show/', [SatuanController::class, 'show'])->name('satuan.getsatuan');
        Route::post('/admin/satuan/proses_tambah/', [SatuanController::class, 'proses_tambah'])->name('satuan.store');
        Route::post('/admin/satuan/proses_ubah/{satuan}', [SatuanController::class, 'proses_ubah']);
        Route::post('/admin/satuan/proses_hapus/{satuan}', [SatuanController::class, 'proses_hapus']);
    });

    // Merk
    Route::middleware(['checkRoleUser:/merk,submenu'])->group(function () {
        Route::resource('/admin/merk', MerkController::class);
        Route::get('/admin/merk/show/', [MerkController::class, 'show'])->name('merk.getmerk');
        Route::post('/admin/merk/proses_tambah/', [MerkController::class, 'proses_tambah'])->name('merk.store');
        Route::post('/admin/merk/proses_ubah/{merk}', [MerkController::class, 'proses_ubah']);
        Route::post('/admin/merk/proses_hapus/{merk}', [MerkController::class, 'proses_hapus']);
    });

    // Barang
    Route::middleware(['checkRoleUser:/barang,submenu'])->group(function () {
        Route::resource('/admin/barang', BarangController::class);
        Route::get('/admin/barang/show/', [BarangController::class, 'show'])->name('barang.getbarang');
        Route::post('/admin/barang/proses_tambah/', [BarangController::class, 'proses_tambah'])->name('barang.store');
        Route::post('/admin/barang/proses_ubah/{barang}', [BarangController::class, 'proses_ubah']);
        Route::post('/admin/barang/proses_hapus/{barang}', [BarangController::class, 'proses_hapus']);
    });

    // Customer
    Route::middleware(['checkRoleUser:/customer,menu'])->group(function () {
        Route::resource('/admin/customer', CustomerController::class);
        Route::get('/admin/customer/show/', [CustomerController::class, 'show'])->name('customer.getcustomer');
        Route::post('/admin/customer/proses_tambah/', [CustomerController::class, 'proses_tambah'])->name('customer.store');
        Route::post('/admin/customer/proses_ubah/{customer}', [CustomerController::class, 'proses_ubah']);
        Route::post('/admin/customer/proses_hapus/{customer}', [CustomerController::class, 'proses_hapus']);
    });

    // Barang Masuk
    Route::middleware(['checkRoleUser:/barang-masuk,submenu'])->group(function () {
        Route::resource('/admin/barang-masuk', BarangmasukController::class);
        Route::get('/admin/barang-masuk/show/', [BarangmasukController::class, 'show'])->name('barang-masuk.getbarang-masuk');
        Route::post('/admin/barang-masuk/proses_tambah/', [BarangmasukController::class, 'proses_tambah'])->name('barang-masuk.store');
        Route::post('/admin/barang-masuk/proses_ubah/{barangmasuk}', [BarangmasukController::class, 'proses_ubah']);
        Route::post('/admin/barang-masuk/proses_hapus/{barangmasuk}', [BarangmasukController::class, 'proses_hapus']);
        Route::get('/admin/barang/getbarang/{id}', [BarangController::class, 'getbarang']);
        Route::get('/admin/barang/listbarang/{param}', [BarangController::class, 'listbarang']);
    });

    // Barang Keluar
    Route::middleware(['checkRoleUser:/lap-barang-masuk,submenu'])->group(function () {
        Route::resource('/admin/barang-keluar', BarangkeluarController::class);
        Route::get('/admin/barang-keluar/show/', [BarangkeluarController::class, 'show'])->name('barang-keluar.getbarang-keluar');
        Route::post('/admin/barang-keluar/proses_tambah/', [BarangkeluarController::class, 'proses_tambah'])->name('barang-keluar.store');
        Route::post('/admin/barang-keluar/proses_ubah/{barangkeluar}', [BarangkeluarController::class, 'proses_ubah']);
        Route::post('/admin/barang-keluar/proses_hapus/{barangkeluar}', [BarangkeluarController::class, 'proses_hapus']);
    });

    // Laporan Barang Masuk
    Route::middleware(['checkRoleUser:/lap-barang-masuk,submenu'])->group(function () {
        Route::resource('/admin/lap-barang-masuk', LapBarangMasukController::class);
        Route::get('/admin/lapbarangmasuk/print/', [LapBarangMasukController::class, 'print'])->name('lap-bm.print');
        Route::get('/admin/lapbarangmasuk/pdf/', [LapBarangMasukController::class, 'pdf'])->name('lap-bm.pdf');
        Route::get('/admin/lap-barang-masuk/show/', [LapBarangMasukController::class, 'show'])->name('lap-bm.getlap-bm');
    });

    // Laporan Barang Keluar
    Route::middleware(['checkRoleUser:/lap-barang-keluar,submenu'])->group(function () {
        Route::resource('/admin/lap-barang-keluar', LapBarangKeluarController::class);
        Route::get('/admin/lapbarangkeluar/print/', [LapBarangKeluarController::class, 'print'])->name('lap-bk.print');
        Route::get('/admin/lapbarangkeluar/pdf/', [LapBarangKeluarController::class, 'pdf'])->name('lap-bk.pdf');
        Route::get('/admin/lap-barang-keluar/show/', [LapBarangKeluarController::class, 'show'])->name('lap-bk.getlap-bk');
    });

    // Laporan Stok Barang
    Route::middleware(['checkRoleUser:/lap-stok-barang,submenu'])->group(function () {
        Route::resource('/admin/lap-stok-barang', LapStokBarangController::class);
        Route::get('/admin/lapstokbarang/print/', [LapStokBarangController::class, 'print'])->name('lap-sb.print');
        Route::get('/admin/lapstokbarang/pdf/', [LapStokBarangController::class, 'pdf'])->name('lap-sb.pdf');
        Route::get('/admin/lap-stok-barang/show/', [LapStokBarangController::class, 'show'])->name('lap-sb.getlap-sb');
    });

    // Master Menu, Role, User, Akses, Web
    Route::middleware(['checkRoleUser:1,othermenu'])->group(function () {

        // Menu
        Route::middleware(['checkRoleUser:2,othermenu'])->group(function () {
            Route::resource('/admin/menu', MenuController::class);
            Route::post('/admin/menu/hapus', [MenuController::class, 'hapus']);
            Route::get('/admin/menu/sortup/{sort}', [MenuController::class, 'sortup']);
            Route::get('/admin/menu/sortdown/{sort}', [MenuController::class, 'sortdown']);
        });

        // Role
        Route::middleware(['checkRoleUser:3,othermenu'])->group(function () {
            Route::resource('/admin/role', RoleController::class);
            Route::get('/admin/role/show/', [RoleController::class, 'show'])->name('role.getrole');
            Route::post('/admin/role/hapus', [RoleController::class, 'hapus']);
        });

        // User
        Route::middleware(['checkRoleUser:4,othermenu'])->group(function () {
            Route::resource('/admin/user', UserController::class);
            Route::get('/admin/user/show/', [UserController::class, 'show'])->name('user.getuser');
            Route::post('/admin/user/hapus', [UserController::class, 'hapus']);
        });

        // Akses
        Route::middleware(['checkRoleUser:5,othermenu'])->group(function () {
            Route::get('/admin/akses/{role}', [AksesController::class, 'index']);
            Route::get('/admin/akses/addAkses/{idmenu}/{idrole}/{type}/{akses}', [AksesController::class, 'addAkses']);
            Route::get('/admin/akses/removeAkses/{idmenu}/{idrole}/{type}/{akses}', [AksesController::class, 'removeAkses']);
            Route::get('/admin/akses/setAll/{role}', [AksesController::class, 'setAllAkses']);
            Route::get('/admin/akses/unsetAll/{role}', [AksesController::class, 'unsetAllAkses']);
        });

        // Web
        Route::middleware(['checkRoleUser:6,othermenu'])->group(function () {
            Route::resource('/admin/web', WebController::class);
        });
    });

    // Part Label (ms_part_label)
    Route::prefix('admin/ms-label')->group(function() {
        Route::get('/', [PartLabelController::class, 'index'])->name('MasterLabel.index');
        Route::get('/getdata', [PartLabelController::class, 'getdata'])->name('MasterLabel.getdata');
        Route::post('/store', [PartLabelController::class, 'store'])->name('MasterLabel.store');
        Route::put('/update/{matnr}', [PartLabelController::class, 'update'])->name('MasterLabel.update');
        Route::delete('/destroy/{matnr}', [PartLabelController::class, 'destroy'])->name('MasterLabel.destroy');
        Route::post('/import', [PartLabelController::class, 'import'])->name('MasterLabel.import');
    });
    
    Route::get('/admin/data-label', [Mina2CooisController::class, 'index'])->name('mina2coois.index');
    Route::get('/admin/data-label/data', [Mina2CooisController::class, 'data'])->name('mina2coois.data');
    Route::post('/admin/data-label/import', [Mina2CooisController::class, 'import'])->name('mina2coois.import');
});

