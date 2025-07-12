<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Kategori;
use App\Models\Retensi;
use Illuminate\Support\Facades\DB;

class LaporanArsipController extends Controller
{
    public function index()
    {
        // Hitung jumlah dokumen berdasarkan status
        $total = Dokumen::count();
        $aktif = Dokumen::where('status', 'Aktif')->count();
        $inaktif = Dokumen::where('status', 'Inaktif')->count();
        $musnah = Dokumen::where('status', 'Musnah')->count();

        // Statistik berdasarkan fungsi (kategori)
        $statistikFungsi = Kategori::withCount('dokumens')
            ->get()
            ->map(function ($kategori) {
                return [
                    'nama' => $kategori->nama_kategori,
                    'jumlah' => $kategori->dokumens_count
                ];
            })
            ->toArray();

        // Statistik berdasarkan jenis arsip
        $statistikJenis = [
            ['nama' => 'Surat Keputusan', 'jumlah' => Dokumen::where('jenis', 'Surat Keputusan')->count()],
            ['nama' => 'Laporan', 'jumlah' => Dokumen::where('jenis', 'Laporan')->count()],
            ['nama' => 'Perjanjian (MoU)', 'jumlah' => Dokumen::where('jenis', 'Perjanjian')->count()],
            ['nama' => 'Surat Masuk', 'jumlah' => SuratMasuk::count()],
            ['nama' => 'Surat Keluar', 'jumlah' => SuratKeluar::count()],
            ['nama' => 'Ijazah & Transkrip', 'jumlah' => Dokumen::where('jenis', 'Ijazah')->orWhere('jenis', 'Transkrip')->count()],
        ];

        // Statistik berdasarkan masa simpan (retensi)
        $statistikRetensi = Retensi::withCount('dokumens')
            ->get()
            ->map(function ($retensi) {
                return [
                    'nama' => $retensi->nama_retensi,
                    'jumlah' => $retensi->dokumens_count
                ];
            })
            ->toArray();

        // Statistik berdasarkan keamanan arsip (sifat)
        $statistikKeamanan = [
            ['nama' => 'Biasa (Publik)', 'jumlah' => Dokumen::where('sifat', 'Biasa')->count()],
            ['nama' => 'Rahasia', 'jumlah' => Dokumen::where('sifat', 'Rahasia')->count()],
            ['nama' => 'Sangat Rahasia', 'jumlah' => Dokumen::where('sifat', 'Sangat Rahasia')->count()],
        ];

        // Kirim data ke view
        return view('landing_page.laporan_arsip', [
            'total' => $total,
            'aktif' => $aktif,
            'inaktif' => $inaktif,
            'musnah' => $musnah,
            'statistikFungsi' => $statistikFungsi,
            'statistikJenis' => $statistikJenis,
            'statistikRetensi' => $statistikRetensi,
            'statistikKeamanan' => $statistikKeamanan,
        ]);
    }
} 