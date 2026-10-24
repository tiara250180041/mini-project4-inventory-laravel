<p align="left">
  <img src="https://img.shields.io/badge/Laravel-12-red?style=flat-square&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8%2B-blue?style=flat-square&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/Database-MySQL-orange?style=flat-square&logo=mysql" alt="MySQL">
</p>

# 📦 Inventory Management System (Laravel)

Aplikasi **Inventory Management System** berbasis Laravel yang dirancang untuk membantu pengelolaan inventaris barang, kategori, supplier, serta pencatatan transaksi stok secara terstruktur, dan komprehensif. Semoga aplikasi ini dapat berfungsi dengan baik, memenuhi kebutuhan pengelolaan inventaris secara digital, serta bermanfaat sebagai portofolio pengembangan perangkat lunak yang profesional.

---

## 1. ✨ Fitur Utama Aplikasi
- **Autentikasi Pengguna**: Sistem login, register, dan manajemen hak akses (role middleware) yang aman.
- **Manajemen Produk & Kategori**: Pengelolaan data produk lengkap dengan relasi kategori, stok, dan harga.
- **Manajemen Supplier**: Pencatatan data supplier, alamat, dan nomor kontak dengan validasi sistem.
- **Pencatatan Transaksi & Stok Kritis**: Memantau keluar masuknya barang serta fitur peringatan otomatis (low-stock warning) jika stok di bawah batas aman.
- **Dashboard & Laporan**: Ringkasan data total produk, kategori, supplier, dan aktivitas stok terkini.

---

## 2. 🛠️ Teknologi & Tools yang Digunakan
| Komponen | Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Framework Backend** | Laravel (PHP) | Kerangka kerja pengembangan web modern |
| **Template Engine** | Blade | Pengelola tampilan antarmuka web |
| **Database** | MySQL / MariaDB (XAMPP) | Penyimpanan basis data relasional |
| **Frontend UI** | Bootstrap / CSS | Desain antarmuka responsif |
| **Code Editor** | Visual Studio Code | Perangkat lunak penyunting kode utama |
| **Version Control** | Git & GitHub | Pengelolaan repositori kode sumber |

---

## 3. 📁 Struktur Direktori Proyek

```text
inventory-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ProductController.php
│   │   │   ├── StockTransactionController.php
│   │   │   └── SupplierController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       ├── Product.php
│       ├── StockTransaction.php
│       └── Supplier.php
├── bootstrap/
│   └── app.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php
│       ├── categories/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── products/
│       ├── stock/
│       └── dashboard.blade.php
├── routes/
│   └── web.php
├── .env.example
├── artisan
├── composer.json
├── composer.lock
└── README.md
```
Struktur di atas menampilkan file dan folder utama aplikasi. Folder bawaan Laravel lainnya tetap dipertahankan.

---

## 4. 🔑 Kredensial / Sandi Akun Uji Coba (Testing Login)
Untuk memudahkan pengujian dan penilaian sistem, berikut adalah akun default yang dapat digunakan untuk masuk ke dalam aplikasi:
- **Email Admin**: admin@inventory.com / admin@gmail.com
- **Password / Sandi**: password123 / admin123
- **Role**: Administrator / Staff Gudang

---

## 5. ⚙️ Panduan Instalasi & Menjalankan Proyek

Pastikan komputer Anda sudah terinstal **PHP**, **Composer**, **Git**, dan **XAMPP (MySQL)**. Ikuti langkah-langkah berikut:

1. **Clone repository ke komputer lokal:**
   ```bash
   git clone https://github.com/tiaracitralestari/inventory-laravel.git

---

## 6. 🌿 Skenario Pengujian Sistem (Testing)
Uji Autentikasi: Memastikan sistem menolak akses langsung ke halaman dashboard jika belum login, serta berhasil masuk menggunakan kredensial yang valid.

Uji Stok Kritis: Menambahkan produk dengan jumlah stok di bawah 5 unit untuk memverifikasi apakah indikator status berubah menjadi peringatan stok menipis (low-stock).

Uji Penanganan Kolom Supplier: Menguji form tambah, edit, dan hapus data supplier untuk memastikan nomor kontak serta relasi data tersimpan dengan aman tanpa error.

---

## 7. 🚀 Rencana Pengembangan Selanjutnya (Future Improvements)
Penambahan fitur ekspor laporan ke format PDF dan Excel.

Integrasi barcode scanner untuk mempercepat proses pencarian produk masuk dan keluar.

Peningkatan sistem notifikasi otomatis berbasis email untuk stok barang yang hampir habis.

---

## 8. 📝 Penutup
Demikian dokumentasi proyek Inventory Management System ini dibuat secara lengkap, terstruktur, dan komprehensif. Semoga aplikasi ini bermanfaat dan dapat dikembangkan lebih lanjut ke depannya. Kritik dan saran yang membangun sangat disambut untuk penyempurnaan aplikasi ini.

---

## 9. 👤 Identitas Pengembang
Nama: Tiara Citra Lestari

NIM: 250180041

Program Studi: Sistem Informasi (Fakultas Teknik)

Universitas: Universitas Malikussaleh