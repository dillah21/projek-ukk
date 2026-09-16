<?php
require_once __DIR__.'/../config/auth.php'; require_once __DIR__.'/../config/database.php'; require_once __DIR__.'/../config/layout.php'; require_login();
$data=$pdo->query("SELECT * FROM produk ORDER BY stok ASC,nama_produk ASC")->fetchAll();layout_header('Stok Barang');
?>
<div class="panel"><div class="panel-head"><h3>Ketersediaan Stok</h3><input id="search" class="search" placeholder="Cari produk..."></div><div class="table-wrap"><table id="dataTable"><thead><tr><th>No</th><th>Produk</th><th>Harga</th><th>Stok</th><th>Status</th></tr></thead><tbody>
<?php foreach($data as $i=>$p): ?><tr><td><?=$i+1?></td><td><?=e($p['nama_produk'])?></td><td>Rp <?=number_format($p['harga'],0,',','.')?></td><td><b><?=$p['stok']?></b></td><td><?php if($p['stok']<=0):?><span class="badge danger">Habis</span><?php elseif($p['stok']<=5):?><span class="badge warning">Menipis</span><?php else:?><span class="badge success">Aman</span><?php endif;?></td></tr><?php endforeach;?>
</tbody></table></div></div><?php layout_footer(); ?>
