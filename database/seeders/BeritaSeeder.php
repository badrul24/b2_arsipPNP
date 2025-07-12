<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        // Create kategori if not exists
        $kategori1 = Kategori::firstOrCreate([
            'nama_kategori' => 'Teknologi'
        ], [
            'keterangan' => 'Berita seputar teknologi informasi'
        ]);

        $kategori2 = Kategori::firstOrCreate([
            'nama_kategori' => 'Pendidikan'
        ], [
            'keterangan' => 'Berita seputar pendidikan'
        ]);

        $kategori3 = Kategori::firstOrCreate([
            'nama_kategori' => 'Arsip'
        ], [
            'keterangan' => 'Berita seputar arsip dan dokumentasi'
        ]);

        // Get or create a user
        $user = User::firstOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Administrator',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // Create sample berita
        $beritas = [
            [
                'judul_berita' => 'Sistem Arsip Digital PNP Diluncurkan',
                'isi_berita' => 'Politeknik Negeri Padang telah meluncurkan sistem arsip digital yang modern dan efisien. Sistem ini memungkinkan pengelolaan dokumen dan arsip secara digital dengan fitur pencarian yang canggih.',
                'kategori_id' => $kategori3->id,
                'gambar' => 'images/default-news.jpg'
            ],
            [
                'judul_berita' => 'Teknologi AI dalam Manajemen Arsip',
                'isi_berita' => 'Artificial Intelligence (AI) telah menjadi tren dalam manajemen arsip modern. Teknologi ini membantu dalam pengelompokan, pencarian, dan pengamanan dokumen digital.',
                'kategori_id' => $kategori1->id,
                'gambar' => 'images/default-news.jpg'
            ],
            [
                'judul_berita' => 'Workshop Digitalisasi Arsip untuk Dosen',
                'isi_berita' => 'Workshop digitalisasi arsip telah diselenggarakan untuk para dosen PNP. Kegiatan ini bertujuan untuk meningkatkan kompetensi dalam pengelolaan arsip digital.',
                'kategori_id' => $kategori2->id,
                'gambar' => 'images/default-news.jpg'
            ],
            [
                'judul_berita' => 'Berita Terbaru tentang Sistem Informasi',
                'isi_berita' => 'Sistem informasi arsip PNP telah diperbarui dengan fitur-fitur terbaru. Update ini mencakup peningkatan keamanan dan kemudahan penggunaan.',
                'kategori_id' => $kategori1->id,
                'gambar' => 'images/default-news.jpg'
            ],
            [
                'judul_berita' => 'Pentingnya Arsip dalam Pendidikan',
                'isi_berita' => 'Arsip memainkan peran penting dalam dunia pendidikan. Dokumen-dokumen akademik perlu dikelola dengan baik untuk mendukung proses pembelajaran.',
                'kategori_id' => $kategori2->id,
                'gambar' => 'images/default-news.jpg'
            ]
        ];

        foreach ($beritas as $beritaData) {
            Berita::firstOrCreate([
                'judul_berita' => $beritaData['judul_berita']
            ], [
                'user_id' => $user->id,
                'kategori_id' => $beritaData['kategori_id'],
                'isi_berita' => $beritaData['isi_berita'],
                'gambar' => $beritaData['gambar']
            ]);
        }
    }
} 