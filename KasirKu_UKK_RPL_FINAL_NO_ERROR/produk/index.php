<?php
require_once __DIR__.'/../config/auth.php'; require_once __DIR__.'/../config/database.php'; require_once __DIR__.'/../config/layout.php'; require_admin();
if(isset($_GET['hapus'])){$s=$pdo->prepare("DELETE FROM produk WHERE produk_id=?");$s->execute([(int)$_GET['hapus']]);header('Location:index.php');exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
 $id=(int)($_POST['produk_id']??0);$nama=trim($_POST['nama_produk']);$harga=(float)$_POST['harga'];$stok=(int)$_POST['stok'];
 if($id){$s=$pdo->prepare("UPDATE produk SET nama_produk=?,harga=?,stok=? WHERE produk_id=?");$s->execute([$nama,$harga,$stok,$id]);}
 else{$s=$pdo->prepare("INSERT INTO produk(nama_produk,harga,stok) VALUES(?,?,?)");$s->execute([$nama,$harga,$stok]);}
 header('Location:index.php');exit;
}
$edit=null;if(isset($_GET['edit'])){$s=$pdo->prepare("SELECT * FROM produk WHERE produk_id=?");$s->execute([(int)$_GET['edit']]);$edit=$s->fetch();}
$data=$pdo->query("SELECT * FROM produk ORDER BY produk_id DESC")->fetchAll(); layout_header('Data Produk');
?>
<div class="panel"><div class="panel-head"><h3><?= $edit?'Edit Produk':'Tambah Produk' ?></h3></div>
<form class="grid-form" method="post"><input type="hidden" name="produk_id" value="<?=e($edit['produk_id']??'')?>">
<div><label>Nama Produk</label><input name="nama_produk" value="<?=e($edit['nama_produk']??'')?>" required></div>
<div><label>Harga</label><input type="number" name="harga" min="0" step="0.01" value="<?=e($edit['harga']??0)?>" required></div>
<div><label>Stok</label><input type="number" name="stok" min="0" value="<?=e($edit['stok']??0)?>" required></div>
<div class="form-actions"><button class="btn primary"><?= $edit?'Update':'Simpan' ?></button><?php if($edit): ?><a class="btn" href="index.php">Batal</a><?php endif;?></div>
</form></div>
<div class="panel"><div class="panel-head"><h3>Daftar Produk</h3></div><div class="table-wrap"><table><thead><tr><th>No</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead><tbody>
<?php foreach($data as $i=>$p): ?><tr><td><?=$i+1?></td><td><?=e($p['nama_produk'])?></td><td>Rp <?=number_format($p['harga'],0,',','.')?></td><td><?=$p['stok']?></td><td><a class="btn sm" href="?edit=<?=$p['produk_id']?>">Edit</a> <a class="btn sm danger" href="?hapus=<?=$p['produk_id']?>" onclick="return confirm('Hapus produk?')">Hapus</a></td></tr><?php endforeach;?>
</tbody></table></div></div><?php layout_footer(); ?>
