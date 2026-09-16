KASIRKU UKK RPL - VERSI SIAP JALAN

Versi ini dibuat supaya masalah "Unknown database db_kasir" tidak terjadi lagi.
Database dibuat OTOMATIS oleh config/database.php.

URUTAN PROJECT:
1. Baca Dokumen Perencanaan
2. Setup Project
3. Database
4. Connection
5. Authentication
6. CRUD
7. Fitur Utama
8. Frontend
9. Validasi & Security
10. Testing
11. Debugging
12. Aplikasi Final

CARA JALAN:
1. Extract folder ke C:\xampp\htdocs\
2. Jalankan Apache dan MySQL.
3. Buka:
   http://localhost/KasirKu_UKK_RPL_FINAL_NO_ERROR/
   atau:
   http://localhost/KasirKu_UKK_RPL_FINAL_NO_ERROR/install.php
4. Database db_kasir otomatis dibuat. Tidak perlu import SQL.
5. Login dengan akun demo.

ADMIN
admin@kasir.test
password

KASIR
kasir@kasir.test
password

JIKA MYSQL ROOT MEMAKAI PASSWORD:
Edit config/database.php:
$pass = 'PASSWORD_MYSQL_KAMU';

JANGAN hapus folder database karena tetap disediakan untuk backup/manual import.
