<?php
session_start();
if (!empty($_SESSION['user'])) { header('Location: dashboard/index.php'); exit; }
$error=$_GET['error']??'';
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login - KasirKu</title><link rel="stylesheet" href="assets/css/app.css"></head>
<body class="login-body"><div class="login-wrap"><div class="login-card">
<div class="logo login-logo"><span>K</span><div><b>KasirKu</b><small>Aplikasi Kasir & Pengelolaan Penjualan</small></div></div>
<h2>Masuk ke dalam sistem</h2><p class="muted">Gunakan akun yang telah terdaftar.</p>
<?php if($error==='invalid'): ?><div class="alert">Email atau password salah.</div><?php endif; ?>
<?php if($error==='empty'): ?><div class="alert">Email dan password wajib diisi.</div><?php endif; ?>
<?php if($error==='forbidden'): ?><div class="alert">Anda tidak memiliki akses ke halaman tersebut.</div><?php endif; ?>
<form action="auth/login.php" method="post">
<label>Email</label><input type="email" name="email" placeholder="nama@email.com" required autofocus>
<label>Password</label><input type="password" name="password" placeholder="Masukkan password" required>
<button class="btn primary full">Login</button>
</form><div class="demo">Demo Admin: <b>admin@kasir.test</b> / <b>password</b><br>Demo Kasir: <b>kasir@kasir.test</b> / <b>password</b></div>
</div></div></body></html>
