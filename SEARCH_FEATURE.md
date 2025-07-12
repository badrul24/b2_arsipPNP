# Fitur Search SIARSIP

## Deskripsi
Fitur search global telah diimplementasikan di SIARSIP yang memungkinkan pengguna untuk mencari konten di seluruh sistem secara real-time.

## Fitur yang Tersedia

### 1. Search Global
- **Berita**: Mencari berdasarkan judul, isi, kategori, dan penulis
- **Dokumen**: Mencari berdasarkan nomor surat, judul, keterangan, kategori, dan kode
- **Surat Masuk**: Mencari berdasarkan nomor agenda, nomor surat pengirim, perihal, keterangan, dan pengirim
- **Surat Keluar**: Mencari berdasarkan nomor agenda, nomor surat keluar, perihal, tujuan surat, pengirim, dan penerima
- **Jurusan**: Mencari berdasarkan nama jurusan, kode jurusan, dan keterangan

### 2. Akses Search
- **Navbar Desktop**: Tombol search dengan input expandable
- **Navbar Mobile**: Tombol search dengan input expandable
- **Halaman Search**: Halaman dedicated untuk pencarian dengan form lengkap

### 3. Keamanan dan Otorisasi
- **Berita**: Dapat diakses oleh semua pengguna (public)
- **Dokumen**: Hanya untuk user yang login dengan filter berdasarkan role dan jurusan
- **Surat Masuk**: Hanya untuk user yang login dengan filter berdasarkan role
- **Surat Keluar**: Hanya untuk user yang login dengan filter berdasarkan role
- **Jurusan**: Dapat diakses oleh semua pengguna (public)

## Implementasi Teknis

### 1. Controller
- **File**: `app/Http/Controllers/SearchController.php`
- **Method**: `search(Request $request)`
- **Fungsi**: Menangani logika pencarian dan filtering

### 2. Route
- **URL**: `/search`
- **Method**: GET
- **Parameter**: `q` (query string)
- **File**: `routes/web.php`

### 3. View
- **File**: `resources/views/search.blade.php`
- **Layout**: Menggunakan `landing_page.user`
- **Fitur**: 
  - Tampilan hasil pencarian yang responsif
  - Kategori hasil dengan icon dan warna berbeda
  - Form pencarian ulang
  - Pagination informasi

### 4. JavaScript
- **File**: `resources/views/partials/navbar.blade.php`
- **Fungsi**:
  - Toggle search input (desktop & mobile)
  - Submit search dengan Enter key
  - Redirect ke halaman search dengan query

## Cara Penggunaan

### 1. Melalui Navbar
1. Klik icon search di navbar
2. Input akan muncul (expandable)
3. Ketik kata kunci
4. Tekan Enter untuk mencari

### 2. Melalui Halaman Search
1. Klik icon search di navbar (tanpa expand)
2. Atau akses langsung `/search`
3. Masukkan kata kunci di form
4. Klik tombol "Cari"

### 3. Melalui URL
- Format: `/search?q=kata_kunci`
- Contoh: `/search?q=berita`

## Hasil Pencarian

### Format Tampilan
Setiap hasil menampilkan:
- **Icon dan Badge**: Menunjukkan jenis konten (Berita, Dokumen, Surat, dll)
- **Judul**: Link ke halaman detail
- **Deskripsi**: Preview konten (150 karakter untuk berita, 100 karakter untuk lainnya)
- **Metadata**: Tanggal, kategori, dan penulis
- **Tombol**: "Lihat Detail" untuk akses langsung

### Limitasi
- **Berita**: Maksimal 5 hasil
- **Dokumen**: Maksimal 5 hasil (jika login)
- **Surat Masuk**: Maksimal 5 hasil (jika login)
- **Surat Keluar**: Maksimal 5 hasil (jika login)
- **Jurusan**: Maksimal 3 hasil
- **Total**: Maksimal 23 hasil ditampilkan

## Filtering dan Otorisasi

### Role-based Access
- **Admin**: Akses penuh ke semua data
- **Operator**: Hanya data dari jurusan sendiri
- **Pimpinan**: Data sesuai dengan role dan disposisi
- **Sekretaris**: Data surat sesuai status
- **Public**: Hanya berita dan jurusan

### Status-based Filtering
- **Surat Masuk**: Filter berdasarkan status surat
- **Surat Keluar**: Filter berdasarkan status surat
- **Dokumen**: Filter berdasarkan status dokumen

## Styling dan UI/UX

### Design System
- **Primary Color**: `#133656` (PNP Blue)
- **Secondary Color**: `#8b5cf6` (Purple)
- **Responsive**: Desktop dan mobile friendly
- **Accessibility**: Keyboard navigation support

### Components
- **Search Input**: Expandable dengan animasi
- **Result Cards**: Hover effects dan shadows
- **Badges**: Color-coded untuk kategori
- **Icons**: SVG icons untuk setiap jenis konten

## Performance

### Optimizations
- **Eager Loading**: Menggunakan `with()` untuk relasi
- **Query Limits**: Membatasi hasil per kategori
- **Indexing**: Menggunakan LIKE queries yang efisien
- **Caching**: Bisa ditambahkan untuk performa lebih baik

### Database Queries
- Menggunakan `where()` dan `orWhere()` untuk pencarian
- `whereHas()` untuk pencarian relasi
- `latest()` untuk sorting berdasarkan tanggal terbaru

## Future Enhancements

### Fitur yang Bisa Ditambahkan
1. **Advanced Search**: Filter berdasarkan tanggal, kategori, dll
2. **Search Suggestions**: Autocomplete berdasarkan data existing
3. **Search History**: Menyimpan riwayat pencarian
4. **Export Results**: Export hasil pencarian ke PDF/Excel
5. **Full-text Search**: Menggunakan Elasticsearch atau similar
6. **Search Analytics**: Tracking pencarian populer

### Technical Improvements
1. **Caching**: Redis cache untuk hasil pencarian
2. **Pagination**: Pagination untuk hasil yang banyak
3. **Real-time Search**: AJAX search tanpa reload
4. **Search Index**: Database indexing untuk performa
5. **API Endpoint**: REST API untuk search

## Troubleshooting

### Common Issues
1. **Search tidak berfungsi**: Pastikan route terdaftar dan controller ada
2. **Hasil kosong**: Cek apakah ada data di database
3. **Permission denied**: Pastikan user login untuk data terbatas
4. **JavaScript error**: Cek console browser untuk error

### Debug
- Cek log Laravel: `storage/logs/laravel.log`
- Cek query database dengan `DB::enableQueryLog()`
- Test route dengan `php artisan route:list`
- Cek view dengan `php artisan view:clear` 