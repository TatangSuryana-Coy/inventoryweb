-- Database: db_inventoryweb
USE db_inventoryweb;

/*Data for the table migrations */

SET IDENTITY_INSERT migrations ON;

INSERT INTO migrations (id, migration, batch) VALUES
(1, '2019_08_19_000000_create_failed_jobs_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2022_10_31_061811_create_menu_table', 1),
(4, '2022_11_01_041110_create_table_role', 1),
(5, '2022_11_01_083314_create_table_user', 1),
(6, '2022_11_03_023905_create_table_submenu', 1),
(7, '2022_11_03_064417_create_tbl_akses', 1),
(8, '2022_11_08_024215_create_tbl_web', 1),
(9, '2022_11_15_131148_create_tbl_jenisbarang', 2),
(10, '2022_11_15_173700_create_tbl_satuan', 3),
(11, '2022_11_15_180434_create_tbl_merk', 4),
(12, '2022_11_16_120018_create_tbl_appreance', 5),
(13, '2022_11_25_141731_create_tbl_barang', 6),
(14, '2022_11_26_011349_create_tbl_customer', 7),
(16, '2022_11_28_151108_create_tbl_barangmasuk', 8),
(17, '2022_11_30_115904_create_tbl_barangkeluar', 9);

SET IDENTITY_INSERT migrations OFF;

SET IDENTITY_INSERT tbl_role ON;
INSERT INTO tbl_role (role_id, role_title, role_slug, role_desc, created_at, updated_at) VALUES
(1, 'Super Admin', 'super-admin', '-', '2022-11-15 10:51:04', '2022-11-15 10:51:04'),
(2, 'Admin', 'admin', '-', '2022-11-15 10:51:04', '2022-11-15 10:51:04'),
(3, 'Operator', 'operator', '-', '2022-11-15 10:51:04', '2022-11-15 10:51:04'),
(4, 'Manajer', 'manajer', NULL, '2022-12-06 09:33:27', '2022-12-06 09:33:27');
SET IDENTITY_INSERT tbl_role OFF;

SET IDENTITY_INSERT tbl_user ON;
INSERT INTO tbl_user (user_id, role_id, user_nmlengkap, user_nama, user_email, user_foto, user_password, created_at, updated_at) VALUES
(1, 1, 'Super Administrator', 'superadmin', 'superadmin@gmail.com', 'undraw_profile.svg', '25d55ad283aa400af464c76d713c07ad', '2022-11-15 10:51:04', '2022-11-15 10:51:04'),
(2, 2, 'Administrator', 'admin', 'admin@gmail.com', 'undraw_profile.svg', '25d55ad283aa400af464c76d713c07ad', '2022-11-15 10:51:04', '2022-11-15 10:51:04'),
(3, 3, 'Operator', 'operator', 'operator@gmail.com', 'undraw_profile.svg', '25d55ad283aa400af464c76d713c07ad', '2022-11-15 10:51:04', '2022-11-15 10:51:04'),
(4, 4, 'Manajer', 'manajer', 'manajer@gmail.com', 'undraw_profile.svg', '25d55ad283aa400af464c76d713c07ad', '2022-12-06 09:33:54', '2022-12-06 09:33:54');
SET IDENTITY_INSERT tbl_user OFF;

SET IDENTITY_INSERT tbl_menu ON;
INSERT INTO tbl_menu (menu_id, menu_judul, menu_slug, menu_icon, menu_redirect, menu_sort, menu_type, created_at, updated_at) VALUES
(1667444041, 'Dashboard', 'dashboard', 'home', '/dashboard', 1, 1, '2022-11-15 10:51:04', '2022-11-15 10:51:04'),
(1668509889, 'Master Barang', 'master-barang', 'package', '-', 2, 2, '2022-11-15 10:58:09', '2022-11-15 11:03:15'),
(1668510437, 'Transaksi', 'transaksi', 'repeat', '-', 4, 2, '2022-11-15 11:07:17', '2022-11-25 15:37:36'),
(1668510568, 'Laporan', 'laporan', 'printer', '-', 5, 2, '2022-11-15 11:09:28', '2022-11-25 15:37:28'),
(1669390641, 'Customer', 'customer', 'user', '/customer', 3, 1, '2022-11-25 15:37:21', '2022-11-25 15:37:36');
SET IDENTITY_INSERT tbl_menu OFF;

SET IDENTITY_INSERT tbl_submenu ON;
INSERT INTO tbl_submenu (submenu_id, menu_id, submenu_judul, submenu_slug, submenu_redirect, submenu_sort, created_at, updated_at) VALUES
(9, 1668510437, 'Barang Masuk', 'barang-masuk', '/barang-masuk', 1, '2022-11-15 11:08:19', '2022-11-15 11:08:19'),
(10, 1668510437, 'Barang Keluar', 'barang-keluar', '/barang-keluar', 2, '2022-11-15 11:08:19', '2022-11-15 11:08:19'),
(17, 1668509889, 'Jenis', 'jenis', '/jenisbarang', 1, '2022-11-24 12:06:48', '2022-11-24 12:06:48'),
(18, 1668509889, 'Satuan', 'satuan', '/satuan', 2, '2022-11-24 12:06:48', '2022-11-24 12:06:48'),
(19, 1668509889, 'Merk', 'merk', '/merk', 3, '2022-11-24 12:06:48', '2022-11-24 12:06:48'),
(20, 1668509889, 'Barang', 'barang', '/barang', 4, '2022-11-24 12:06:48', '2022-11-24 12:06:48'),
(21, 1668510568, 'Lap Barang Masuk', 'lap-barang-masuk', '/lap-barang-masuk', 1, '2022-11-30 12:56:24', '2022-11-30 12:56:24'),
(22, 1668510568, 'Lap Barang Keluar', 'lap-barang-keluar', '/lap-barang-keluar', 2, '2022-11-30 12:56:24', '2022-11-30 12:56:24'),
(23, 1668510568, 'Lap Stok Barang', 'lap-stok-barang', '/lap-stok-barang', 3, '2022-11-30 12:56:24', '2022-11-30 12:56:24');
SET IDENTITY_INSERT tbl_submenu OFF;

SET IDENTITY_INSERT tbl_jenisbarang ON;
INSERT INTO tbl_jenisbarang (jenisbarang_id, jenisbarang_nama, jenisbarang_slug, jenisbarang_ket, created_at, updated_at) VALUES
(11, 'Elektronik', 'elektronik', NULL, '2022-11-25 15:24:18', '2022-11-25 15:25:39'),
(12, 'Perangkat Komputer', 'perangkat-komputer', NULL, '2022-11-25 15:26:15', '2022-11-25 15:27:16'),
(13, 'Besi', 'besi', NULL, '2022-11-25 15:27:33', '2022-11-25 15:27:33');
SET IDENTITY_INSERT tbl_jenisbarang OFF;

SET IDENTITY_INSERT tbl_satuan ON;
INSERT INTO tbl_satuan (satuan_id, satuan_nama, satuan_slug, satuan_keterangan, created_at, updated_at) VALUES
(1, 'Kg', 'kg', NULL, '2022-11-15 17:50:38', '2022-11-24 12:39:04'),
(5, 'Pcs', 'pcs', NULL, '2022-11-24 12:39:15', '2022-11-24 12:39:21'),
(7, 'Qty', 'qty', NULL, '2022-11-24 12:39:59', '2022-11-24 12:39:59');
SET IDENTITY_INSERT tbl_satuan OFF;

SET IDENTITY_INSERT tbl_merk ON;
INSERT INTO tbl_merk (merk_id, merk_nama, merk_slug, merk_keterangan, created_at, updated_at) VALUES
(1, 'Huawei', 'huawei', NULL, '2022-11-15 18:14:09', '2022-11-15 18:14:09'),
(2, 'Lenovo', 'lenovo', NULL, '2022-11-15 18:14:33', '2022-11-15 18:14:45'),
(7, 'Steel', 'steel', NULL, '2022-11-25 15:29:27', '2022-11-25 15:29:27');
SET IDENTITY_INSERT tbl_merk OFF;

SET IDENTITY_INSERT tbl_barang ON;
INSERT INTO tbl_barang (barang_id, jenisbarang_id, satuan_id, merk_id, barang_kode, barang_nama, barang_slug, barang_harga, barang_stok, barang_gambar, created_at, updated_at) VALUES
(5, 12, 7, 2, 'BRG-1669390175622', 'Motherboard', 'motherboard', '4000000', '0', 'image.png', '2022-11-25 15:30:12', '2022-11-25 15:30:12'),
(6, 13, 1, 7, 'BRG-1669390220236', 'Baut 24mm', 'baut-24mm', '1000000', '0', 'image.png', '2022-11-25 15:30:50', '2022-11-29 14:30:37');
SET IDENTITY_INSERT tbl_barang OFF;

SET IDENTITY_INSERT tbl_customer ON;
INSERT INTO tbl_customer (customer_id, customer_nama, customer_slug, customer_alamat, customer_notelp, created_at, updated_at) VALUES
(2, 'Radhian Sobarna', 'radhian-sobarna', 'Sumedang', '087817379229', '2022-11-26 01:36:34', '2022-11-26 01:43:58');
SET IDENTITY_INSERT tbl_customer OFF;

SET IDENTITY_INSERT tbl_barangmasuk ON;
INSERT INTO tbl_barangmasuk (bm_id, bm_kode, barang_kode, customer_id, bm_tanggal, bm_jumlah, created_at, updated_at) VALUES
(1, 'BM-1669730554623', 'BRG-1669390220236', 2, '2022-11-01', '50', '2022-11-29 14:02:43', '2022-11-29 14:20:13'),
(2, 'BM-1669731639801', 'BRG-1669390175622', 2, '2022-11-30', '10', '2022-11-29 14:20:55', '2022-11-29 14:20:55');
SET IDENTITY_INSERT tbl_barangmasuk OFF;

SET IDENTITY_INSERT tbl_barangkeluar ON;
INSERT INTO tbl_barangkeluar (bk_id, bk_kode, barang_kode, bk_tanggal, bk_tujuan, bk_jumlah, created_at, updated_at) VALUES
(2, 'BK-1669811950758', 'BRG-1669390220236', '2022-11-01', 'Gudang Tasikmalaya', '20', '2022-11-30 12:39:22', '2022-11-30 12:47:14'),
(3, 'BK-1669812439198', 'BRG-1669390175622', '2022-11-02', 'Gudang Prindapan', '5', '2022-11-30 12:47:39', '2023-07-26 04:18:25');
SET IDENTITY_INSERT tbl_barangkeluar OFF;

SET IDENTITY_INSERT tbl_appreance ON;
INSERT INTO tbl_appreance (appreance_id, user_id, appreance_layout, appreance_theme, appreance_menu, appreance_header, appreance_sidestyle, created_at, updated_at) VALUES
(2, 1, 'sidebar-mini', 'light-mode', 'light-menu', 'header-light', 'default-menu', '2022-11-22 09:45:47', '2022-11-24 13:00:20');
SET IDENTITY_INSERT tbl_appreance OFF;

SET IDENTITY_INSERT tbl_web ON;
INSERT INTO tbl_web (web_id, web_nama, web_logo, web_deskripsi, created_at, updated_at) VALUES
(1, 'Inventoryweb', 'default.png', 'Mengelola Data Barang Masuk & Barang Keluar', '2022-11-15 10:51:04', '2022-11-22 09:41:39');
SET IDENTITY_INSERT tbl_web OFF;