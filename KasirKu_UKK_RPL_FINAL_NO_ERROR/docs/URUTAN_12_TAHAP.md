# URUTAN PEMBUATAN PROJECT UKK RPL

Urutan project mengikuti alur pada Modul Fase 2 Development Project UKK RPL:

1. **Baca Dokumen Perencanaan**
   - Pahami kebutuhan aplikasi kasir.
   - Role: Admin dan Kasir/Petugas.
   - Fitur: autentikasi, produk, pelanggan, stok, transaksi.

2. **Setup Project**
   - PHP 8.x
   - MySQL/MariaDB
   - XAMPP/Laragon
   - Struktur folder aplikasi.

3. **Database**
   - Database `db_kasir`.
   - Tabel `pengguna`, `pelanggan`, `produk`, `transaksi`, `detail_transaksi`.

4. **Connection**
   - PDO ke MySQL.
   - File koneksi: `config/database.php`.

5. **Authentication**
   - Login/logout.
   - Session.
   - Role.
   - Password hashing/verifikasi.

6. **CRUD**
   - CRUD Produk.
   - CRUD Pelanggan.

7. **Fitur Utama**
   - Stok barang.
   - Transaksi penjualan.
   - Total transaksi.
   - Stok berkurang otomatis.

8. **Frontend**
   - Dashboard.
   - Sidebar.
   - Form dan tabel.
   - Responsive UI.

9. **Validasi & Security**
   - Validasi form.
   - Prepared statement.
   - Password hash.
   - Proteksi halaman dan role.

10. **Testing**
    - Login.
    - CRUD.
    - Stok.
    - Transaksi.
    - Hak akses.

11. **Debugging**
    - Perbaikan error koneksi.
    - Perbaikan query.
    - Perbaikan session/akses.
    - Perbaikan tampilan.

12. **Aplikasi Final**
    - Seluruh modul terhubung.
    - Database siap.
    - UI siap.
    - Testing selesai.
