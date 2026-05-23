# 📚 SIARSIP - Sistem Informasi Arsip Politeknik Negeri Padang

<p align="center">
  <img src="public/icons/logo_pnp.png" alt="Logo PNP" width="200">
</p>

<p align="center">
  <strong>Sistem Informasi Arsip Digital untuk Politeknik Negeri Padang</strong>
</p>

## 📋 Deskripsi Proyek

SIARSIP (Sistem Informasi Arsip) adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola arsip digital di lingkungan Politeknik Negeri Padang. Sistem ini memungkinkan pengelolaan dokumen, surat masuk, surat keluar, dan arsip lainnya secara digital dengan fitur keamanan dan akses berbasis peran.

### 🎯 Tujuan
- Digitalisasi sistem arsip konvensional
- Meningkatkan efisiensi pengelolaan dokumen
- Memudahkan pencarian dan akses arsip
- Meningkatkan keamanan dan integritas data arsip

## ✨ Fitur Utama

### 🔐 Sistem Autentikasi & Otorisasi
- Login/Register dengan validasi
- Multi-role user (Admin, Operator, Pimpinan, dll.)
- Google OAuth integration
- Role-based access control

### 📄 Manajemen Dokumen
- Upload dan pengelolaan dokumen digital
- Kategorisasi dokumen (Surat, Laporan, Memorandum, dll.)
- Sistem klasifikasi dan kode arsip
- Retensi dan lokasi penyimpanan

### 📨 Manajemen Surat
- **Surat Masuk**: Pencatatan, disposisi, tracking status
- **Surat Keluar**: Pembuatan, pengiriman, monitoring
- Sistem disposisi otomatis
- Notifikasi status surat

### 🔍 Pencarian & Laporan
- Pencarian global di seluruh arsip
- Filter berdasarkan kategori, status, tanggal
- Laporan arsip dalam format PDF
- Statistik dan dashboard

### 🏢 Manajemen Organisasi
- Pengelolaan jurusan dan divisi
- Struktur organisasi
- User management per unit

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 10** - PHP Framework
- **MySQL** - Database
- **Laravel Sanctum** - API Authentication
- **Laravel Socialite** - OAuth Integration

### Frontend
- **Blade Templates** - Template Engine
- **Tailwind CSS** - CSS Framework
- **Alpine.js** - JavaScript Framework
- **Vite** - Build Tool

### Tools & Libraries
- **Laravel Excel** - Import/Export Excel
- **DomPDF** - PDF Generation
- **Laravel Debugbar** - Development Tools

## 📋 Prasyarat Sistem

Sebelum menginstal SIARSIP, pastikan sistem Anda memenuhi persyaratan berikut:

### Server Requirements
- **PHP**: >= 8.1
- **Composer**: >= 2.0
- **MySQL**: >= 8.0 atau MariaDB >= 10.5
- **Node.js**: >= 16.0 (untuk build assets)
- **NPM**: >= 8.0

### PHP Extensions
```bash
php-bcmath
php-curl
php-dom
php-fileinfo
php-gd
php-mbstring
php-mysql
php-xml
php-zip
```

## 🚀 Langkah-langkah Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/username/arsip_pnp.git
cd arsip_pnp
```

### 2. Install Dependencies PHP
```bash
composer install
```

### 3. Install Dependencies Node.js
```bash
npm install
```

### 4. Setup Environment
```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arsip_pnp
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Buat Database
```sql
CREATE DATABASE arsip_pnp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Jalankan Migration
```bash
php artisan migrate
```

### 8. Jalankan Seeder (Opsional)
```bash
php artisan db:seed
```

### 9. Build Assets
```bash
npm run build
```

### 10. Setup Storage Link
```bash
php artisan storage:link
```

### 11. Set Permissions (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 12. Jalankan Server Development
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 👤 Setup User Default

Setelah instalasi, Anda dapat login dengan kredensial default:

### Admin Default
- **Email**: admin@pnp.ac.id
- **Password**: password

### Operator Default
- **Email**: operator@pnp.ac.id
- **Password**: password

> ⚠️ **Penting**: Ganti password default setelah instalasi!

## 🔧 Konfigurasi Tambahan

### Google OAuth (Opsional)
Untuk menggunakan login Google, tambahkan di `.env`:
```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Mail Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 📁 Struktur Direktori Penting

```
arsip_pnp/
├── app/
│   ├── Http/Controllers/     # Controller aplikasi
│   ├── Models/              # Model Eloquent
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── public/
│   ├── dokumen_uploads/    # File dokumen
│   ├── surat_masuk_uploads/ # File surat masuk
│   └── surat_keluar_upload/ # File surat keluar
├── resources/
│   └── views/              # Blade templates
└── routes/
    └── web.php             # Web routes
```

## 🔐 Sistem Keamanan

### Role & Permission
- **Admin**: Akses penuh ke semua fitur
- **Operator**: Manajemen dokumen per jurusan
- **Pimpinan**: Monitoring dan disposisi
- **Sekretaris**: Verifikasi surat masuk
- **Kepala Lembaga/Bidang**: Akses terbatas

### File Upload Security
- Validasi tipe file (PDF, DOC, DOCX, XLS, XLSX)
- Batasan ukuran file (max 10MB)
- Sanitasi nama file
- Storage terpisah per kategori

## 📊 Database Schema

### Tabel Utama
- `users` - Data pengguna
- `dokumens` - Arsip dokumen
- `surat_masuks` - Surat masuk
- `surat_keluars` - Surat keluar
- `disposisis` - Disposisi surat
- `kategoris` - Kategori dokumen
- `kodes` - Kode klasifikasi
- `jurusans` - Data jurusan
- `divisis` - Data divisi

## 🚀 Deployment ke Production

### 1. Environment Production
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### 2. Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Setup Web Server
#### Apache (.htaccess sudah disediakan)
```apache
DocumentRoot /path/to/arsip_pnp/public
```

#### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/arsip_pnp/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🐛 Troubleshooting

### Common Issues

#### 1. Permission Denied
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 2. Composer Memory Limit
```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

#### 3. Database Connection Error
- Periksa konfigurasi database di `.env`
- Pastikan MySQL service berjalan
- Cek kredensial database

#### 4. File Upload Error
- Periksa permission folder upload
- Pastikan `storage:link` sudah dijalankan
- Cek konfigurasi `filesystems.php`

## 📞 Support & Kontribusi

### Tim Pengembang
- **Lead Developer**: [Nama Developer]
- **UI/UX Designer**: [Nama Designer]
- **Project Manager**: [Nama PM]

### Kontak
- **Email**: arsip@pnp.ac.id
- **Website**: https://pnp.ac.id
- **GitHub**: https://github.com/username/arsip_pnp

### Cara Berkontribusi
1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## 🙏 Ucapan Terima Kasih

Terima kasih kepada semua pihak yang telah berkontribusi dalam pengembangan SIARSIP:
- Politeknik Negeri Padang
- Tim Pengembang
- Stakeholder dan User

---

**© 2024 Politeknik Negeri Padang. All rights reserved.**# SIARSIP
