![Inventoryweb-thumbnail](https://user-images.githubusercontent.com/47371845/205918923-dcc3b42f-4d67-46af-9bd1-d6b577b868cb.jpg)

# Inventoryweb [2025-07-08]

**Inventoryweb** adalah aplikasi berbasis web untuk manajemen stok barang, transaksi keluar-masuk barang, serta pelaporan dan pengelolaan data master secara terintegrasi.  
Aplikasi ini dibangun menggunakan framework **Laravel** dan mengadopsi template admin modern berbasis **Bootstrap 5** (Sash Admin).

---

## 📋 Fitur Utama

-   **Dashboard**  
    Menampilkan ringkasan data stok, transaksi, dan grafik statistik.

-   **Master Data**

    -   Jenis Barang
    -   Satuan Barang
    -   Merk Barang
    -   Data Barang
    -   Customer

-   **Transaksi**

    -   Barang Masuk (penerimaan barang)
    -   Barang Keluar (pengeluaran barang)

-   **Laporan**

    -   Laporan Barang Masuk
    -   Laporan Barang Keluar
    -   Laporan Stok Barang

-   **Manajemen User & Hak Akses**

    -   Multi user: superadmin, admin, operator, manajer
    -   Pengaturan hak akses per role
    -   Pengaturan menu dinamis (tambah/hapus menu)

-   **Pengaturan Website**

    -   Setting profil perusahaan
    -   Setting tampilan aplikasi

-   **Import & Export Data**

    -   Import data master dan transaksi via Excel
    -   Export laporan ke Excel

-   **Notifikasi & Validasi**

    -   Notifikasi SweetAlert untuk aksi sukses/gagal
    -   Validasi form dan upload file

-   **Pencarian & Filter Data**

    -   Pencarian cepat pada tabel (Yajra DataTables)
    -   Filter data berdasarkan tanggal, kategori, dsb

-   **Responsive Design**
    -   Tampilan mobile friendly

---

## 🆕 Menu & Halaman Tambahan

-   **Data Label (Control Label)**

    -   Menampilkan dan mengelola data label produksi dari tabel `mina2_coois`
    -   Fitur import data label dari Excel
    -   Tabel dinamis dengan filter dan pencarian

-   **Master Part Label**

    -   CRUD data part label (tambah, edit, hapus)
    -   Import data part label dari Excel

-   **User Profile**

    -   Halaman profil user, edit data diri, dan ubah password

-   **Pengaturan Hak Akses Menu**

    -   Pengaturan akses menu per user/role secara dinamis

-   **Log Aktivitas**

    -   Melihat riwayat aktivitas user di aplikasi

-   **Halaman Import Data**

    -   Import data dari Excel untuk master dan transaksi
    -   Validasi otomatis dan notifikasi hasil import

-   **Halaman Export Data**

    -   Export data master/transaksi/laporan ke file Excel

-   **Halaman Maintenance**
    -   Menu untuk backup database dan reset data (khusus admin)

---

## 🔌 Teknologi & Plugin

-   **Laravel 9+**
-   **Bootstrap 5 (Sash Admin Template)**
-   **Yajra Laravel Datatables** (server-side datatable)
-   **SweetAlert2** (notifikasi interaktif)
-   **jQuery**
-   **Datetime Picker**
-   **Maatwebsite Excel** (import/export Excel)
-   **FontAwesome** (icon)
-   **Middleware Auth & Role**
-   **Custom Helper & Validation**

---

## ⚙️ Kebutuhan Sistem

-   PHP >= 8.1
-   **SQL Server** (Microsoft SQL Server)
-   Composer >= 2.3.9
-   Node.js >= 16.14.0 & NPM >= 8.3.1
-   Web server (Apache/Nginx/XAMPP/Laragon)
-   Ekstensi PHP SQLSRV & PDO_SQLSRV aktif

---

## 🚀 Instalasi & Setup

1. **Clone Project**

    ```
    git clone https://github.com/USERNAME/inventoryweb.git
    ```

    Atau download ZIP lalu ekstrak.

2. **Buat Database di SQL Server**

    - Buat database baru, misal: `db_inventoryweb` di SQL Server Management Studio.

3. **Konfigurasi ENV**

    - Ubah file `env.development` menjadi `.env`
    - Atur koneksi database di file `.env`:
        ```
        DB_CONNECTION=sqlsrv
        DB_HOST=localhost
        DB_PORT=1433
        DB_DATABASE=db_inventoryweb
        DB_USERNAME=sa
        DB_PASSWORD=your_password
        ```

4. **Install Dependency**

    ```
    composer install
    npm install
    npm run build
    ```

5. **Generate Key & Storage Link**

    ```
    php artisan key:generate
    php artisan storage:link
    ```

6. **Import Database**

    - Import file `db_inventoryweb.sql` ke SQL Server menggunakan SQL Server Management Studio.

7. **Jalankan Aplikasi**

    ```
    php artisan serve
    ```

    Buka `http://127.0.0.1:8000/` di browser.

8. **Login Default**
    - superadmin / 12345678
    - admin / 12345678
    - operator / 12345678
    - manajer / 12345678

---

## ⚠️ Tips Upload File Excel Besar

Pastikan setting berikut di `php.ini`:

```
max_execution_time = 300
upload_max_filesize = 50M
post_max_size = 50M
memory_limit = 1024M
```

---

## ⚠️ Catatan Penting: Storage Link

Jika perintah

```
php artisan storage:link
```

tidak berjalan atau gagal:

-   **Pastikan** sudah menghapus folder/link `public/storage` jika sudah ada sebelumnya.
-   **Jalankan terminal/CMD sebagai Administrator** (khusus Windows).
-   **Cek permission** folder `public` dan `storage`.
-   Jika di shared hosting yang tidak support symlink, **copy manual** isi `storage/app/public` ke `public/storage`.
-   Untuk Windows, bisa juga buat symlink manual:
    ```
    mklink /D public\storage storage\app\public
    ```
-   Jika masih gagal, cek pesan error di terminal untuk solusi lebih spesifik.

---

## 📝 Git Workflow

Untuk upload perubahan ke GitHub:

```
git add .
git commit -m "Deskripsi perubahan"
git push
```

---

## 📞 Kontak & Kontribusi

Jika ada pertanyaan, bug, atau ingin kontribusi, silakan buat issue atau pull request di repository ini.

---

**Inventoryweb** — Solusi manajemen stok dan transaksi barang berbasis web yang mudah, cepat, dan aman.
