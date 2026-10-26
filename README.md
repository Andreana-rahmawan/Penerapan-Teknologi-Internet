# Katalog Buku (PHP Native + MySQL)

## Cara menjalankan
1. Install XAMPP/Laragon, nyalakan Apache + MySQL.
2. Salin folder `katalog_buku` ke `htdocs` (XAMPP) atau `www` (Laragon).
3. Buka phpMyAdmin -> tab Import -> pilih `database.sql`.
4. Sesuaikan `config.php` jika user/password MySQL berbeda.
5. Buka `http://localhost/katalog_buku/install.php` sekali (membuat user admin), lalu hapus file itu.
6. Buka `http://localhost/katalog_buku/` -> login: **admin / admin123**.

## Struktur
- config.php: koneksi DB, session, bahasa, helper e()/clean()/require_login()
- lang/id.php, lang/en.php: kamus bahasa
- login.php / logout.php: autentikasi $_SESSION
- index.php (Read), create.php, edit.php (Update), delete.php (Delete)
- form_helper.php: validasi (if-else, filter_var) + form bersama
