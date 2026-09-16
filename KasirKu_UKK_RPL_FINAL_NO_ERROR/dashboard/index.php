<?php
require_once __DIR__.'/../config/auth.php'; require_once __DIR__.'/../config/database.php'; require_once __DIR__.'/../config/layout.php'; require_login();
$produk=(int)$pdo->query("SELECT COUNT(*) FROM produk")->fetchColumn();
$pelanggan=(int)$pdo->query("SELECT COUNT(*) FROM pelanggan")->fetchColumn();
$stok=(int)$pdo->query("SELECT COALESCE(SUM(stok),0) FROM produk")->fetchColumn();
$transaksi=(int)$pdo->query("SELECT COUNT(*) FROM transaksi")->fetchColumn();
layout_header('Dashboard');
?>
<div class="welcome"><div><span class="badge success">SISTEM AKTIF</span><h2>Selamat datang, <?=e($_SESSION['user']['nama_pengguna'])?> 👋</h2><p>Kelola penjualan, produk, pelanggan, dan stok dari satu tempat.</p></div></div>
<div class="stats">
<div class="stat"><small>Total Produk</small><b><?=$produk?></b><span>Data barang</span></div>
<div class="stat"><small>Total Pelanggan</small><b><?=$pelanggan?></b><span>Data pelanggan</span></div>
<div class="stat"><small>Total Stok</small><b><?=$stok?></b><span>Unit barang</span></div>
<div class="stat"><small>Total Transaksi</small><b><?=$transaksi?></b><span>Transaksi tersimpan</span></div>
</div>
<div class="panel"><div class="panel-head"><h3>Akses Cepat</h3></div><div class="quick">
<a href="../transaksi/index.php" class="quick-card">▰<b>Transaksi</b><span>Input penjualan</span></a>
<a href="../stok/index.php" class="quick-card">▥<b>Stok Barang</b><span>Cek ketersediaan</span></a>
<?php if($_SESSION['user']['peran']==='admin'): ?><a href="../produk/index.php" class="quick-card">▤<b>Produk</b><span>Kelola barang</span></a><a href="../pelanggan/index.php" class="quick-card">♙<b>Pelanggan</b><span>Kelola pelanggan</span></a><?php endif; ?>
</div></div>
<?php layout_footer(); ?>
