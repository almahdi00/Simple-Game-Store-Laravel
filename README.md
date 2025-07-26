# 🎮 GameStore - Laravel Game Marketplace

GameStore adalah aplikasi web marketplace game berbasis Laravel. Aplikasi ini memungkinkan pengguna untuk melihat, membeli, dan memainkan game berbasis HTML5/WebGL secara langsung di browser setelah pembelian disetujui oleh admin.

## ✨ Fitur Utama

- 🔐 Autentikasi multi-role (Admin & User) menggunakan Laravel Breeze
- 🕹️ CRUD Game dan Kategori (admin)
- 📂 Upload file game dalam format ZIP
- 🛒 Fitur keranjang belanja dan transaksi
- ✅ Sistem approval pembelian oleh Admin
- 🧩 Mainkan game HTML5/WebGL langsung di situs (iframe)
- 🔍 Fitur pencarian game
- 📁 Penyimpanan file secara lokal/CDN

---

## 📚 Teknologi yang Digunakan

- PHP 8.x
- Laravel 11
- Laravel Breeze (Authentication)
- Tailwind CSS
- SQLite/MySQL
- HTML5/WebGL (untuk game)
- JavaScript (untuk frontend interaktif)

---

## 🚀 Instalasi Lokal

```bash
# Clone repo ini
git clone https://github.com/username/gamestore.git
cd gamestore

# Install dependency
composer install
npm install && npm run build

# Copy .env dan generate key
cp .env.example .env
php artisan key:generate

# Atur koneksi database di .env
DB_DATABASE=gamestore
DB_USERNAME=root
DB_PASSWORD=

# Jalankan migrasi dan seeder
php artisan migrate --seed

# Jalankan server lokal
php artisan serve
