<?php
/*
 * Koneksi + bootstrap database.
 * Untuk XAMPP/Laragon default: MySQL localhost, user root, password kosong.
 * File ini otomatis membuat db_kasir dan tabel yang diperlukan.
 */
$host = 'localhost';
$db   = 'db_kasir';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    // 1) Sambung ke MySQL tanpa memilih database.
    $server = new PDO("mysql:host=$host;charset=$charset", $user, $pass, $options);

    // 2) Buat database jika belum ada.
    $server->exec(
        "CREATE DATABASE IF NOT EXISTS `$db`
         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
    );

    // 3) Sambung ke database.
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);

    // 4) Buat tabel sesuai rancangan.
    $pdo->exec("CREATE TABLE IF NOT EXISTS pengguna (
        pengguna_id INT(11) NOT NULL AUTO_INCREMENT,
        nama_pengguna VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        peran ENUM('admin','kasir','petugas') NOT NULL DEFAULT 'kasir',
        PRIMARY KEY (pengguna_id)
    ) ENGINE=InnoDB");

    $pdo->exec("CREATE TABLE IF NOT EXISTS pelanggan (
        pelanggan_id INT(11) NOT NULL AUTO_INCREMENT,
        nama_pelanggan VARCHAR(100) NOT NULL,
        alamat TEXT,
        telepon VARCHAR(20),
        PRIMARY KEY (pelanggan_id)
    ) ENGINE=InnoDB");

    $pdo->exec("CREATE TABLE IF NOT EXISTS produk (
        produk_id INT(11) NOT NULL AUTO_INCREMENT,
        nama_produk VARCHAR(100) NOT NULL,
        harga DECIMAL(10,2) NOT NULL DEFAULT 0,
        stok INT(11) NOT NULL DEFAULT 0,
        PRIMARY KEY (produk_id)
    ) ENGINE=InnoDB");

    $pdo->exec("CREATE TABLE IF NOT EXISTS transaksi (
        transaksi_id INT(11) NOT NULL AUTO_INCREMENT,
        tanggal DATETIME NOT NULL,
        pelanggan_id INT(11) NULL,
        pengguna_id INT(11) NOT NULL,
        total_harga DECIMAL(10,2) NOT NULL DEFAULT 0,
        PRIMARY KEY (transaksi_id),
        CONSTRAINT fk_trans_pelanggan FOREIGN KEY (pelanggan_id)
            REFERENCES pelanggan(pelanggan_id) ON DELETE SET NULL ON UPDATE CASCADE,
        CONSTRAINT fk_trans_pengguna FOREIGN KEY (pengguna_id)
            REFERENCES pengguna(pengguna_id) ON UPDATE CASCADE
    ) ENGINE=InnoDB");

    $pdo->exec("CREATE TABLE IF NOT EXISTS detail_transaksi (
        detail_id INT(11) NOT NULL AUTO_INCREMENT,
        transaksi_id INT(11) NOT NULL,
        produk_id INT(11) NOT NULL,
        jumlah INT(11) NOT NULL,
        harga DECIMAL(10,2) NOT NULL,
        subtotal DECIMAL(10,2) NOT NULL,
        PRIMARY KEY (detail_id),
        CONSTRAINT fk_detail_trans FOREIGN KEY (transaksi_id)
            REFERENCES transaksi(transaksi_id) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT fk_detail_produk FOREIGN KEY (produk_id)
            REFERENCES produk(produk_id) ON UPDATE CASCADE
    ) ENGINE=InnoDB");

    // 5) Buat akun demo jika belum ada. Hash dibuat oleh PHP, bukan hash statis.
    $count = (int)$pdo->query("SELECT COUNT(*) FROM pengguna")->fetchColumn();
    if ($count === 0) {
        $hash = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO pengguna
            (nama_pengguna,email,password,peran) VALUES (?,?,?,'admin'),(?,?,?,'kasir')");
        $stmt->execute([
            'Administrator','admin@kasir.test',$hash,
            'Kasir','kasir@kasir.test',$hash
        ]);
    }

    // 6) Data contoh hanya diisi bila tabel produk/pelanggan masih kosong.
    if ((int)$pdo->query("SELECT COUNT(*) FROM pelanggan")->fetchColumn() === 0) {
        $stmt=$pdo->prepare("INSERT INTO pelanggan(nama_pelanggan,alamat,telepon) VALUES (?,?,?),(?,?,?)");
        $stmt->execute([
            'Pelanggan Umum','-','-',
            'Budi Santoso','Tasikmalaya','081234567890'
        ]);
    }

    if ((int)$pdo->query("SELECT COUNT(*) FROM produk")->fetchColumn() === 0) {
        $stmt=$pdo->prepare("INSERT INTO produk(nama_produk,harga,stok) VALUES
            ('Pensil 2B',3000,50),('Buku Tulis',5000,40),('Pulpen',3500,35),
            ('Penghapus',2500,25),('Spidol',7000,20)");
        $stmt->execute();
    }
} catch (PDOException $e) {
    http_response_code(500);
    die(
        '<div style="font-family:Arial;padding:30px;max-width:760px;margin:auto">' .
        '<h2>Koneksi MySQL belum berhasil</h2>' .
        '<p><b>Pastikan MySQL XAMPP/Laragon sudah Start.</b></p>' .
        '<p>Detail: ' . htmlspecialchars($e->getMessage()) . '</p>' .
        '<p>Jika password root MySQL kamu tidak kosong, ubah variabel <code>$pass</code> di <code>config/database.php</code>.</p>' .
        '</div>'
    );
}
