CREATE DATABASE IF NOT EXISTS db_kasir CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_kasir;

CREATE TABLE IF NOT EXISTS pengguna(
 pengguna_id INT(11) AUTO_INCREMENT PRIMARY KEY,
 nama_pengguna VARCHAR(100) NOT NULL,
 email VARCHAR(100) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 peran ENUM('admin','kasir','petugas') NOT NULL DEFAULT 'kasir'
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pelanggan(
 pelanggan_id INT(11) AUTO_INCREMENT PRIMARY KEY,
 nama_pelanggan VARCHAR(100) NOT NULL,
 alamat TEXT,
 telepon VARCHAR(20)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS produk(
 produk_id INT(11) AUTO_INCREMENT PRIMARY KEY,
 nama_produk VARCHAR(100) NOT NULL,
 harga DECIMAL(10,2) NOT NULL DEFAULT 0,
 stok INT(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS transaksi(
 transaksi_id INT(11) AUTO_INCREMENT PRIMARY KEY,
 tanggal DATETIME NOT NULL,
 pelanggan_id INT(11) NULL,
 pengguna_id INT(11) NOT NULL,
 total_harga DECIMAL(10,2) NOT NULL DEFAULT 0,
 CONSTRAINT fk_trans_pelanggan FOREIGN KEY(pelanggan_id) REFERENCES pelanggan(pelanggan_id) ON DELETE SET NULL ON UPDATE CASCADE,
 CONSTRAINT fk_trans_pengguna FOREIGN KEY(pengguna_id) REFERENCES pengguna(pengguna_id) ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS detail_transaksi(
 detail_id INT(11) AUTO_INCREMENT PRIMARY KEY,
 transaksi_id INT(11) NOT NULL,
 produk_id INT(11) NOT NULL,
 jumlah INT(11) NOT NULL,
 harga DECIMAL(10,2) NOT NULL,
 subtotal DECIMAL(10,2) NOT NULL,
 CONSTRAINT fk_detail_trans FOREIGN KEY(transaksi_id) REFERENCES transaksi(transaksi_id) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT fk_detail_produk FOREIGN KEY(produk_id) REFERENCES produk(produk_id) ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Jika import SQL manual, buat hash password dari PHP password_hash().
-- Installer otomatis di config/database.php sudah menangani akun demo.
