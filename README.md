![Inventoryweb-thumnail](https://user-images.githubusercontent.com/47371845/205918923-dcc3b42f-4d67-46af-9bd1-d6b577b868cb.jpg)

## _:information_source: Inventoryweb_

Aplikasi ini bisa anda gunakan untuk mengontrol stock barang yang anda miliki sehingga jelas transaksi keluar dan masuk barang tersebut juga mempermudah kontrol barang tersebut.
<br><br>
Untuk tampilannya saya sudah pasang template admin `bootstrap v5` yaitu `sash admin`.

## _:sparkles: Fitur_

-   **Dashboard**
-   **Jenis Barang**
-   **Satuan Barang**
-   **Merk Barang**
-   **Barang**
-   **Customer**
-   **Barang Masuk**
-   **Barang Keluar**
-   **Laporan Barang Masuk**
-   **Laporan Barang Keluar**
-   **Laporan Stok Barang**
-   **Setting Website**
-   **Setting Hak Akses user per Role**
-   **Setting Menu (bisa tambah menu atau bisa hapus menu)**

## _:electric_plug: Plugin_

-   **Yajra Datatables**
-   **SweetAlert**
-   **jQuery**
-   **Datetime picker**

## _:gear: Requirement_

<p>
<img alt="gambar" src="https://img.shields.io/badge/PHP%20-%5E8.1-green"/>
<img alt="gambar" src="https://img.shields.io/badge/Node JS%20-%5E16.14.0-green"/>
<img alt="gambar" src="https://img.shields.io/badge/Npm%20-%5E8.3.1-green"/>
<img alt="gambar" src="https://img.shields.io/badge/Composer%20-%5E2.3.9-green"/>
</p>

## _:rocket: Instalasi_

#### :arrow_right: Clone Project / Download File

Clone Project dengan perintah terminal `gitbash` sebagai berikut:

```
git clone git@github.com:radhiant/laravel-inventoryweb.git
```

Atau bisa klik tombol download Zip dan extrak file tersebut

#### :arrow_right: Buat Database

Buat Database `db_inventoryweb`

#### :arrow_right: Config ENV

Ubah file dari `env.development` jadi `.env`

Setting `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` yang ada di file `.env` sesuai Nama Database mysql kalian

#### :arrow_right: Set Up

Buka Terminal di proyek folder Anda dan jalankan perintah dibawah ini:

```
composer install
```

```
php artisan storage:link
```

#### :arrow_right: Import Database

Import file database `db_inventoryweb.sql` yang ada di folder `database/db` ke phpmyadmin

#### :arrow_right: Jalankan Aplikasi

```
php artisan serve
```

copy & paste `http://127.0.0.1:8000/` ke browser anda.

#### :arrow_right: Login Default

username: `superadmin` password: `12345678`
<br>
username: `admin` password: `12345678`
<br>
username: `operator` password: `12345678`
<br>
username: `manajer` password: `12345678`

untuk support upload file excel bersar, pastikan setting ini di php.ini
max_execution_time = 300
upload_max_filesize = 50M
post_max_size = 50M
memory_limit = 1024M
