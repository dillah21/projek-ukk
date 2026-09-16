<?php
require_once __DIR__.'/../config/auth.php'; require_once __DIR__.'/../config/database.php'; require_once __DIR__.'/../config/layout.php'; require_login();
$products=$pdo->query("SELECT * FROM produk WHERE stok>0 ORDER BY nama_produk")->fetchAll();
$customers=$pdo->query("SELECT * FROM pelanggan ORDER BY nama_pelanggan")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){
 try{
  $pdo->beginTransaction();
  $pid=(int)$_POST['produk_id'];$qty=(int)$_POST['jumlah'];$cid=$_POST['pelanggan_id']!==''?(int)$_POST['pelanggan_id']:null;
  $s=$pdo->prepare("SELECT * FROM produk WHERE produk_id=? FOR UPDATE");$s->execute([$pid]);$p=$s->fetch();
  if(!$p || $qty<1 || $p['stok']<$qty) throw new Exception('Stok tidak mencukupi.');
  $total=$p['harga']*$qty;
  $s=$pdo->prepare("INSERT INTO transaksi(tanggal,pelanggan_id,pengguna_id,total_harga) VALUES(NOW(),?,?,?)");
  $s->execute([$cid,$_SESSION['user']['pengguna_id'],$total]);$tid=$pdo->lastInsertId();
  $s=$pdo->prepare("INSERT INTO detail_transaksi(transaksi_id,produk_id,jumlah,harga,subtotal) VALUES(?,?,?,?,?)");
  $s->execute([$tid,$pid,$qty,$p['harga'],$total]);
  $s=$pdo->prepare("UPDATE produk SET stok=stok-? WHERE produk_id=?");$s->execute([$qty,$pid]);
  $pdo->commit(); header("Location:index.php?success=1");exit;
 }catch(Exception $e){if($pdo->inTransaction())$pdo->rollBack();$err=$e->getMessage();}
}
$recent=$pdo->query("SELECT t.transaksi_id,t.tanggal,t.total_harga,p.nama_produk,d.jumlah,u.nama_pengguna FROM transaksi t JOIN detail_transaksi d ON d.transaksi_id=t.transaksi_id JOIN produk p ON p.produk_id=d.produk_id JOIN pengguna u ON u.pengguna_id=t.pengguna_id ORDER BY t.transaksi_id DESC LIMIT 10")->fetchAll();
layout_header('Transaksi Penjualan');
?>
<?php if(isset($_GET['success'])):?><div class="alert success-alert">Transaksi berhasil disimpan dan stok otomatis berkurang.</div><?php endif;?>
<?php if(isset($err)):?><div class="alert"><?=e($err)?></div><?php endif;?>
<div class="transaction-grid"><div class="panel"><div class="panel-head"><h3>Input Penjualan</h3></div>
<form method="post"><label>Produk</label><select name="produk_id" required><option value="">Pilih produk</option><?php foreach($products as $p):?><option value="<?=$p['produk_id']?>"><?=e($p['nama_produk'])?> — Rp <?=number_format($p['harga'],0,',','.')?> (stok <?=$p['stok']?>)</option><?php endforeach;?></select>
<label>Pelanggan <small>(opsional)</small></label><select name="pelanggan_id"><option value="">Umum</option><?php foreach($customers as $c):?><option value="<?=$c['pelanggan_id']?>"><?=e($c['nama_pelanggan'])?></option><?php endforeach;?></select>
<label>Jumlah</label><input type="number" name="jumlah" min="1" value="1" required><button class="btn primary full">Simpan Transaksi</button></form></div>
<div class="panel"><div class="panel-head"><h3>Alur Transaksi</h3></div><ol class="steps"><li>Pilih barang dan kuantitas.</li><li>Masukkan pelanggan bila diperlukan.</li><li>Sistem menghitung total otomatis.</li><li>Simpan transaksi.</li><li>Stok produk berkurang otomatis.</li></ol></div></div>
<div class="panel"><div class="panel-head"><h3>Riwayat Transaksi</h3></div><div class="table-wrap"><table><thead><tr><th>ID</th><th>Tanggal</th><th>Produk</th><th>Jumlah</th><th>Total</th><th>Kasir</th></tr></thead><tbody><?php foreach($recent as $r):?><tr><td>#<?=$r['transaksi_id']?></td><td><?=e($r['tanggal'])?></td><td><?=e($r['nama_produk'])?></td><td><?=$r['jumlah']?></td><td>Rp <?=number_format($r['total_harga'],0,',','.')?></td><td><?=e($r['nama_pengguna'])?></td></tr><?php endforeach;?></tbody></table></div></div>
<?php layout_footer(); ?>
