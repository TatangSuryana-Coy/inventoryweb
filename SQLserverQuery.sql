-- Converted full SQL Server-compatible script from original MySQL dump
-- Database: db_inventoryweb

-- Create Database
CREATE DATABASE db_inventoryweb;
GO

USE db_inventoryweb;
GO

-- Table: failed_jobs
CREATE TABLE failed_jobs (
  id BIGINT IDENTITY(1,1) PRIMARY KEY,
  uuid NVARCHAR(255) NOT NULL UNIQUE,
  connection NVARCHAR(MAX) NOT NULL,
  queue NVARCHAR(MAX) NOT NULL,
  payload NVARCHAR(MAX) NOT NULL,
  exception NVARCHAR(MAX) NOT NULL,
  failed_at DATETIME NOT NULL DEFAULT GETDATE()
);
GO

-- Table: migrations
CREATE TABLE migrations (
  id INT IDENTITY(1,1) PRIMARY KEY,
  migration NVARCHAR(255) NOT NULL,
  batch INT NOT NULL
);
GO

-- Table: password_resets
CREATE TABLE password_resets (
  email NVARCHAR(255) NOT NULL,
  token NVARCHAR(255) NOT NULL,
  created_at DATETIME NULL
);
GO

-- Table: personal_access_tokens
CREATE TABLE personal_access_tokens (
  id BIGINT IDENTITY(1,1) PRIMARY KEY,
  tokenable_type NVARCHAR(255) NOT NULL,
  tokenable_id BIGINT NOT NULL,
  name NVARCHAR(255) NOT NULL,
  token NVARCHAR(64) NOT NULL UNIQUE,
  abilities NVARCHAR(MAX) NULL,
  last_used_at DATETIME NULL,
  expires_at DATETIME NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_akses
CREATE TABLE tbl_akses (
  akses_id INT IDENTITY(1,1) PRIMARY KEY,
  menu_id NVARCHAR(255) NULL,
  submenu_id NVARCHAR(255) NULL,
  othermenu_id NVARCHAR(255) NULL,
  role_id NVARCHAR(255) NOT NULL,
  akses_type NVARCHAR(255) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_appreance
CREATE TABLE tbl_appreance (
  appreance_id INT IDENTITY(1,1) PRIMARY KEY,
  user_id NVARCHAR(255) NOT NULL,
  appreance_layout NVARCHAR(255) NULL,
  appreance_theme NVARCHAR(255) NULL,
  appreance_menu NVARCHAR(255) NULL,
  appreance_header NVARCHAR(255) NULL,
  appreance_sidestyle NVARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_barang
CREATE TABLE tbl_barang (
  barang_id INT IDENTITY(1,1) PRIMARY KEY,
  jenisbarang_id NVARCHAR(255) NULL,
  satuan_id NVARCHAR(255) NULL,
  merk_id NVARCHAR(255) NULL,
  barang_kode NVARCHAR(255) NOT NULL,
  barang_nama NVARCHAR(255) NOT NULL,
  barang_slug NVARCHAR(255) NULL,
  barang_harga NVARCHAR(255) NOT NULL,
  barang_stok NVARCHAR(255) NOT NULL,
  barang_gambar NVARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_barangkeluar
CREATE TABLE tbl_barangkeluar (
  bk_id INT IDENTITY(1,1) PRIMARY KEY,
  bk_kode NVARCHAR(255) NOT NULL,
  barang_kode NVARCHAR(255) NOT NULL,
  bk_tanggal NVARCHAR(255) NOT NULL,
  bk_tujuan NVARCHAR(255) NULL,
  bk_jumlah NVARCHAR(255) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_barangmasuk
CREATE TABLE tbl_barangmasuk (
  bm_id INT IDENTITY(1,1) PRIMARY KEY,
  bm_kode NVARCHAR(255) NOT NULL,
  barang_kode NVARCHAR(255) NOT NULL,
  customer_id NVARCHAR(255) NOT NULL,
  bm_tanggal NVARCHAR(255) NOT NULL,
  bm_jumlah NVARCHAR(255) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_customer
CREATE TABLE tbl_customer (
  customer_id INT IDENTITY(1,1) PRIMARY KEY,
  customer_nama NVARCHAR(255) NOT NULL,
  customer_slug NVARCHAR(255) NOT NULL,
  customer_alamat NVARCHAR(MAX) NULL,
  customer_notelp NVARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_jenisbarang
CREATE TABLE tbl_jenisbarang (
  jenisbarang_id INT IDENTITY(1,1) PRIMARY KEY,
  jenisbarang_nama NVARCHAR(255) NOT NULL,
  jenisbarang_slug NVARCHAR(255) NOT NULL,
  jenisbarang_ket NVARCHAR(MAX) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_merk
CREATE TABLE tbl_merk (
  merk_id INT IDENTITY(1,1) PRIMARY KEY,
  merk_nama NVARCHAR(255) NOT NULL,
  merk_slug NVARCHAR(255) NOT NULL,
  merk_keterangan NVARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_menu
CREATE TABLE tbl_menu (
  menu_id INT IDENTITY(1,1) PRIMARY KEY,
  menu_judul NVARCHAR(255) NOT NULL,
  menu_slug NVARCHAR(255) NOT NULL,
  menu_icon NVARCHAR(255) NOT NULL,
  menu_redirect NVARCHAR(255) NOT NULL,
  menu_sort NVARCHAR(255) NOT NULL,
  menu_type NVARCHAR(255) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_role
CREATE TABLE tbl_role (
  role_id INT IDENTITY(1,1) PRIMARY KEY,
  role_title NVARCHAR(255) NOT NULL,
  role_slug NVARCHAR(255) NOT NULL,
  role_desc NVARCHAR(MAX) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_satuan
CREATE TABLE tbl_satuan (
  satuan_id INT IDENTITY(1,1) PRIMARY KEY,
  satuan_nama NVARCHAR(255) NOT NULL,
  satuan_slug NVARCHAR(255) NOT NULL,
  satuan_keterangan NVARCHAR(255) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_submenu
CREATE TABLE tbl_submenu (
  submenu_id INT IDENTITY(1,1) PRIMARY KEY,
  menu_id NVARCHAR(255) NOT NULL,
  submenu_judul NVARCHAR(255) NOT NULL,
  submenu_slug NVARCHAR(255) NOT NULL,
  submenu_redirect NVARCHAR(255) NOT NULL,
  submenu_sort NVARCHAR(255) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_user
CREATE TABLE tbl_user (
  user_id INT IDENTITY(1,1) PRIMARY KEY,
  role_id NVARCHAR(255) NOT NULL,
  user_nmlengkap NVARCHAR(255) NOT NULL,
  user_nama NVARCHAR(255) NOT NULL,
  user_email NVARCHAR(255) NOT NULL,
  user_foto NVARCHAR(255) NULL,
  user_password NVARCHAR(255) NOT NULL,
  user_status NVARCHAR(255) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Table: tbl_web
CREATE TABLE tbl_web (
  web_id INT IDENTITY(1,1) PRIMARY KEY,
  web_nama NVARCHAR(255) NOT NULL,
  web_logo NVARCHAR(255) NULL,
  web_deskripsi NVARCHAR(MAX) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
GO

-- Insert data section to follow next --
