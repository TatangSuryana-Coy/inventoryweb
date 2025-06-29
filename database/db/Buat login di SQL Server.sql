-- 1️⃣ Buat login di SQL Server
CREATE LOGIN tatsuyaid
WITH PASSWORD = '123456789',
     CHECK_POLICY = OFF,  -- Nonaktifkan kebijakan password
     CHECK_EXPIRATION = OFF;  -- Nonaktifkan kedaluwarsa password
GO

-- 2️⃣ Gunakan database yang ingin diakses
USE db_inventoryweb;
GO

-- 3️⃣ Buat user di dalam database yang terkait ke login tadi
CREATE USER tatsuyaid FOR LOGIN tatsuyaid;
GO

-- 4️⃣ Berikan permission sebagai user database
EXEC sp_addrolemember 'db_datareader', 'tatsuyaid';  -- Boleh SELECT
EXEC sp_addrolemember 'db_datawriter', 'tatsuyaid';  -- Boleh INSERT, UPDATE, DELETE
EXEC sp_addrolemember 'db_ddladmin',  'tatsuyaid';   -- Boleh CREATE/ALTER/DROP table, view dll
GO
