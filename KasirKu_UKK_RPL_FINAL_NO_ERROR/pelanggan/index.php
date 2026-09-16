<?php
require_once __DIR__.'/../config/auth.php'; require_once __DIR__.'/../config/database.php'; require_once __DIR__.'/../config/layout.php'; require_admin();
if(isset($_GET['hapus'])){$s=$pdo->prepare("DELETE FROM pelanggan WHERE pelanggan_id=?");$s->execute([(int)$_GET['hapus']]);header('Location:index.php');exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
 $id=(int)($_POST['pelanggan_id']??0);$v=[trim($_POST['nama_pelanggan']),trim($_POST['alamat']),trim($_POST['telepon'])];
 if($id){$s=$pdo->prepare("UPDATE pelanggan SET nama_pelanggan=?,alamat=?,telepon=? WHERE pelanggan_id=?");$s->execute([...$v,$id]);}
 else{$s=$pdo->prepare("INSERT INTO pelanggan(nama_pelanggan,alamat,telepon) VALUES(?,?,?)");$s->execute($v);}
 header('Location:index.php');exit;
}
$edit=null;if(isset($_GET['edit'])){$s=$pdo->prepare("SELECT * FROM pelanggan WHERE pelanggan_id=?");$s->execute([(int)$_GET['edit']]);$edit=$s->fetch();}
$data=$pdo->query("SELECT * FROM pelanggan ORDER BY pelanggan_id DESC")->fetchAll();layout_header('Data Pelanggan');
?>
<div class="panel"><div class="panel-head"><h3><?= $edit?'Edit Pelanggan':'Tambah Pelanggan' ?></h3></div>
<form class="grid-form" method="post"><input type="hidden" name="pelanggan_id" value="<?=e($edit['pelanggan_id']??'')?>">
<div><label>Nama Pelanggan</label><input name="nama_pelanggan" value="<?=e($edit['nama_pelanggan']??'')?>" required></div>
<div><label>No. Telepon</label><input name="telepon" value="<?=e($edit['telepon']??'')?>"></div>
<div class="wide"><label>Alamat</label><textarea name="alamat"><?=e($edit['alamat']??'')?></textarea></div>
<div class="form-actions"><button class="btn primary"><?= $edit?'Update':'Simpan' ?></button><?php if($edit): ?><a class="btn" href="index.php">Batal</a><?php endif;?></div></form></div>
<div class="panel"><div class="panel-head"><h3>Daftar Pelanggan</h3></div><div class="table-wrap"><table><thead><tr><th>No</th><th>Nama</th><th>Telepon</th><th>Alamat</th><th>Aksi</th></tr></thead><tbody>
<?php foreach($data as $i=>$p): ?><tr><td><?=$i+1?></td><td><?=e($p['nama_pelanggan'])?></td><td><?=e($p['telepon'])?></td><td><?=e($p['alamat'])?></td><td><a class="btn sm" href="?edit=<?=$p['pelanggan_id']?>">Edit</a> <a class="btn sm danger" href="?hapus=<?=$p['pelanggan_id']?>" onclick="return confirm('Hapus pelanggan?')">Hapus</a></td></tr><?php endforeach;?>
</tbody></table></div></div><?php layout_footer(); ?>
