<?php
function layout_header($title) {
    $u = $_SESSION['user'];
    $base = str_contains($_SERVER['PHP_SELF'], '/dashboard/') || str_contains($_SERVER['PHP_SELF'], '/produk/') ||
            str_contains($_SERVER['PHP_SELF'], '/pelanggan/') || str_contains($_SERVER['PHP_SELF'], '/stok/') ||
            str_contains($_SERVER['PHP_SELF'], '/transaksi/') ? '../' : '';
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title) ?> - KasirKu</title>
<link rel="stylesheet" href="<?= $base ?>assets/css/app.css">
</head>
<body>
<div class="app">
<aside class="sidebar">
  <div class="logo"><span>K</span><div><b>KasirKu</b><small>UKK RPL</small></div></div>
  <nav>
    <a href="<?= $base ?>dashboard/index.php">▣ <span>Dashboard</span></a>
    <?php if ($u['peran']==='admin'): ?>
      <a href="<?= $base ?>produk/index.php">▤ <span>Data Produk</span></a>
      <a href="<?= $base ?>pelanggan/index.php">♙ <span>Data Pelanggan</span></a>
    <?php endif; ?>
    <a href="<?= $base ?>stok/index.php">▥ <span>Stok Barang</span></a>
    <a href="<?= $base ?>transaksi/index.php">▰ <span>Transaksi</span></a>
  </nav>
  <div class="side-bottom"><a class="logout-link" href="<?= $base ?>auth/logout.php">↪ <span>Logout</span></a></div>
</aside>
<main class="main">
<header class="topbar"><div><h1><?= e($title) ?></h1><p>Manajemen penjualan berbasis web</p></div>
<div class="profile"><b><?= e($u['nama_pengguna']) ?></b><span><?= e($u['peran']) ?></span></div></header>
<div class="content">
<?php }
function layout_footer(){ ?>
</div></main></div>
<script src="<?= str_contains($_SERVER['PHP_SELF'],'/dashboard/') || str_contains($_SERVER['PHP_SELF'],'/produk/') || str_contains($_SERVER['PHP_SELF'],'/pelanggan/') || str_contains($_SERVER['PHP_SELF'],'/stok/') || str_contains($_SERVER['PHP_SELF'],'/transaksi/') ? '../' : '' ?>assets/js/app.js"></script>
</body></html>
<?php } ?>
