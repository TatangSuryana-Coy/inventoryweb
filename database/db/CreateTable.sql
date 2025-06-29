-- Database creation (opsional, bisa dijalankan manual)
CREATE DATABASE db_inventoryweb;
GO
USE db_inventoryweb;
GO

-- Table: tbl_role
IF OBJECT_ID('tbl_role', 'U') IS NOT NULL DROP TABLE tbl_role;
CREATE TABLE tbl_role (
  role_id INT IDENTITY(1,1) PRIMARY KEY,
  role_title VARCHAR(255) NOT NULL,
  role_slug VARCHAR(255) NOT NULL,
  role_desc VARCHAR(MAX) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_user
IF OBJECT_ID('tbl_user', 'U') IS NOT NULL DROP TABLE tbl_user;
CREATE TABLE tbl_user (
  user_id INT IDENTITY(1,1) PRIMARY KEY,
  role_id INT NOT NULL,
  user_nmlengkap VARCHAR(255) NOT NULL,
  user_nama VARCHAR(255) NOT NULL,
  user_email VARCHAR(255) NOT NULL,
  user_foto VARCHAR(255) NOT NULL,
  user_password VARCHAR(255) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_menu
IF OBJECT_ID('tbl_menu', 'U') IS NOT NULL DROP TABLE tbl_menu;
CREATE TABLE tbl_menu (
  menu_id INT IDENTITY(1,1) PRIMARY KEY,
  menu_judul VARCHAR(255) NOT NULL,
  menu_slug VARCHAR(255) NOT NULL,
  menu_icon VARCHAR(255) NOT NULL,
  menu_redirect VARCHAR(255) NOT NULL,
  menu_sort VARCHAR(255) NOT NULL,
  menu_type VARCHAR(255) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_submenu
IF OBJECT_ID('tbl_submenu', 'U') IS NOT NULL DROP TABLE tbl_submenu;
CREATE TABLE tbl_submenu (
  submenu_id INT IDENTITY(1,1) PRIMARY KEY,
  menu_id INT NOT NULL,
  submenu_judul VARCHAR(255) NOT NULL,
  submenu_slug VARCHAR(255) NOT NULL,
  submenu_redirect VARCHAR(255) NOT NULL,
  submenu_sort VARCHAR(255) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_akses
IF OBJECT_ID('tbl_akses', 'U') IS NOT NULL DROP TABLE tbl_akses;
CREATE TABLE tbl_akses (
  akses_id INT IDENTITY(1,1) PRIMARY KEY,
  menu_id INT NULL,
  submenu_id INT NULL,
  othermenu_id INT NULL,
  role_id INT NOT NULL,
  akses_type VARCHAR(255) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_appreance
IF OBJECT_ID('tbl_appreance', 'U') IS NOT NULL DROP TABLE tbl_appreance;
CREATE TABLE tbl_appreance (
  appreance_id INT IDENTITY(1,1) PRIMARY KEY,
  user_id INT NOT NULL,
  appreance_layout VARCHAR(255) NULL,
  appreance_theme VARCHAR(255) NULL,
  appreance_menu VARCHAR(255) NULL,
  appreance_header VARCHAR(255) NULL,
  appreance_sidestyle VARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_jenisbarang
IF OBJECT_ID('tbl_jenisbarang', 'U') IS NOT NULL DROP TABLE tbl_jenisbarang;
CREATE TABLE tbl_jenisbarang (
  jenisbarang_id INT IDENTITY(1,1) PRIMARY KEY,
  jenisbarang_nama VARCHAR(255) NOT NULL,
  jenisbarang_slug VARCHAR(255) NOT NULL,
  jenisbarang_ket VARCHAR(MAX) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_satuan
IF OBJECT_ID('tbl_satuan', 'U') IS NOT NULL DROP TABLE tbl_satuan;
CREATE TABLE tbl_satuan (
  satuan_id INT IDENTITY(1,1) PRIMARY KEY,
  satuan_nama VARCHAR(255) NOT NULL,
  satuan_slug VARCHAR(255) NOT NULL,
  satuan_keterangan VARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_merk
IF OBJECT_ID('tbl_merk', 'U') IS NOT NULL DROP TABLE tbl_merk;
CREATE TABLE tbl_merk (
  merk_id INT IDENTITY(1,1) PRIMARY KEY,
  merk_nama VARCHAR(255) NOT NULL,
  merk_slug VARCHAR(255) NOT NULL,
  merk_keterangan VARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_barang
IF OBJECT_ID('tbl_barang', 'U') IS NOT NULL DROP TABLE tbl_barang;
CREATE TABLE tbl_barang (
  barang_id INT IDENTITY(1,1) PRIMARY KEY,
  jenisbarang_id INT NULL,
  satuan_id INT NULL,
  merk_id INT NULL,
  barang_kode VARCHAR(255) NOT NULL UNIQUE,
  barang_nama VARCHAR(255) NOT NULL,
  barang_slug VARCHAR(255) NULL,
  barang_harga VARCHAR(255) NOT NULL,
  barang_stok INT NOT NULL, -- Ubah dari VARCHAR(255) ke INT
  barang_gambar VARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_customer
IF OBJECT_ID('tbl_customer', 'U') IS NOT NULL DROP TABLE tbl_customer;
CREATE TABLE tbl_customer (
  customer_id INT IDENTITY(1,1) PRIMARY KEY,
  customer_nama VARCHAR(255) NOT NULL,
  customer_slug VARCHAR(255) NOT NULL,
  customer_alamat VARCHAR(MAX) NULL,
  customer_notelp VARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_barangmasuk
IF OBJECT_ID('tbl_barangmasuk', 'U') IS NOT NULL DROP TABLE tbl_barangmasuk;
CREATE TABLE tbl_barangmasuk (
  bm_id INT IDENTITY(1,1) PRIMARY KEY,
  bm_kode VARCHAR(255) NOT NULL,
  barang_kode VARCHAR(255) NOT NULL,
  customer_id INT NOT NULL,
  bm_tanggal VARCHAR(255) NOT NULL,
  bm_jumlah INT NOT NULL, -- Ubah dari VARCHAR(255) ke INT
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_barangkeluar
IF OBJECT_ID('tbl_barangkeluar', 'U') IS NOT NULL DROP TABLE tbl_barangkeluar;
CREATE TABLE tbl_barangkeluar (
  bk_id INT IDENTITY(1,1) PRIMARY KEY,
  bk_kode VARCHAR(255) NOT NULL,
  barang_kode VARCHAR(255) NOT NULL,
  bk_tanggal VARCHAR(255) NOT NULL,
  bk_tujuan VARCHAR(255) NULL,
  bk_jumlah INT NOT NULL, -- Ubah dari VARCHAR(255) ke INT
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: tbl_web
IF OBJECT_ID('tbl_web', 'U') IS NOT NULL DROP TABLE tbl_web;
CREATE TABLE tbl_web (
  web_id INT IDENTITY(1,1) PRIMARY KEY,
  web_nama VARCHAR(255) NOT NULL,
  web_logo VARCHAR(255) NOT NULL,
  web_deskripsi VARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- Table: failed_jobs
IF OBJECT_ID('failed_jobs', 'U') IS NOT NULL DROP TABLE failed_jobs;
CREATE TABLE failed_jobs (
  id BIGINT IDENTITY(1,1) PRIMARY KEY,
  uuid VARCHAR(255) NOT NULL UNIQUE,
  connection VARCHAR(MAX) NOT NULL,
  queue VARCHAR(MAX) NOT NULL,
  payload VARCHAR(MAX) NOT NULL,
  exception VARCHAR(MAX) NOT NULL,
  failed_at DATETIME NOT NULL DEFAULT GETDATE()
);

-- Table: migrations
IF OBJECT_ID('migrations', 'U') IS NOT NULL DROP TABLE migrations;
CREATE TABLE migrations (
  id INT IDENTITY(1,1) PRIMARY KEY,
  migration VARCHAR(255) NOT NULL,
  batch INT NOT NULL
);

-- Table: personal_access_tokens
IF OBJECT_ID('personal_access_tokens', 'U') IS NOT NULL DROP TABLE personal_access_tokens;
CREATE TABLE personal_access_tokens (
  id BIGINT IDENTITY(1,1) PRIMARY KEY,
  tokenable_type VARCHAR(255) NOT NULL,
  tokenable_id BIGINT NOT NULL,
  name VARCHAR(255) NOT NULL,
  token VARCHAR(64) NOT NULL UNIQUE,
  abilities VARCHAR(MAX) NULL,
  last_used_at DATETIME NULL,
  expires_at DATETIME NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- =========================
-- FOREIGN KEY CONSTRAINTS
-- =========================

ALTER TABLE tbl_user
ADD CONSTRAINT FK_tbl_user_role_id FOREIGN KEY (role_id) REFERENCES tbl_role(role_id);

ALTER TABLE tbl_appreance
ADD CONSTRAINT FK_tbl_appreance_user_id FOREIGN KEY (user_id) REFERENCES tbl_user(user_id);

ALTER TABLE tbl_akses
ADD CONSTRAINT FK_tbl_akses_role_id FOREIGN KEY (role_id) REFERENCES tbl_role(role_id);

ALTER TABLE tbl_akses
ADD CONSTRAINT FK_tbl_akses_menu_id FOREIGN KEY (menu_id) REFERENCES tbl_menu(menu_id);

ALTER TABLE tbl_akses
ADD CONSTRAINT FK_tbl_akses_submenu_id FOREIGN KEY (submenu_id) REFERENCES tbl_submenu(submenu_id);

ALTER TABLE tbl_submenu
ADD CONSTRAINT FK_tbl_submenu_menu_id FOREIGN KEY (menu_id) REFERENCES tbl_menu(menu_id);

ALTER TABLE tbl_barang
ADD CONSTRAINT FK_tbl_barang_jenisbarang_id FOREIGN KEY (jenisbarang_id) REFERENCES tbl_jenisbarang(jenisbarang_id);

ALTER TABLE tbl_barang
ADD CONSTRAINT FK_tbl_barang_satuan_id FOREIGN KEY (satuan_id) REFERENCES tbl_satuan(satuan_id);

ALTER TABLE tbl_barang
ADD CONSTRAINT FK_tbl_barang_merk_id FOREIGN KEY (merk_id) REFERENCES tbl_merk(merk_id);

ALTER TABLE tbl_barangmasuk
ADD CONSTRAINT FK_tbl_barangmasuk_barang_kode FOREIGN KEY (barang_kode) REFERENCES tbl_barang(barang_kode);

ALTER TABLE tbl_barangmasuk
ADD CONSTRAINT FK_tbl_barangmasuk_customer_id FOREIGN KEY (customer_id) REFERENCES tbl_customer(customer_id);

ALTER TABLE tbl_barangkeluar
ADD CONSTRAINT FK_tbl_barangkeluar_barang_kode FOREIGN KEY (barang_kode) REFERENCES tbl_barang(barang_kode);
