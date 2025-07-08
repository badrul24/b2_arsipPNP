<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\Dokumen;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan statistik dan notifikasi.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil statistik total berdasarkan role
        list(
            $totalSuratMasuk,
            $totalSuratKeluar,
            $totalDokumen,
            $totalDisposisi
        ) = $this->getStatistics($user);

        // 2. Ambil data untuk notifikasi di header
        $notifications = $this->getNotifications($user);

        // 3. Ambil arsip terbaru untuk tabel di dashboard
        $recentItems = $this->getRecentItems($user);

        // 4. Hitung total arsip
        $totalArsip = $totalSuratMasuk + $totalSuratKeluar + $totalDokumen;

        return view('layouts.dashboard', compact(
            'totalArsip',
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalDokumen',
            'totalDisposisi',
            'notifications',
            'recentItems'
        ));
    }

    /**
     * Menghitung statistik total (untuk card) berdasarkan role user.
     */
    private function getStatistics($user): array
    {
        if ($user->isAdmin() || $user->isSekretaris() || $user->isPimpinan()) {
            $totalSuratMasuk = SuratMasuk::count();
            $totalSuratKeluar = SuratKeluar::count();
            $totalDokumen = Dokumen::count();
            $totalDisposisi = Disposisi::count();
        } elseif ($user->isKepalaLembaga() || $user->isKepalaBidang()) {
            // Kepala Lembaga & Kepala Bidang tetap melihat data berdasarkan disposisi yang mereka terima.
            $disposisiSuratIds = Disposisi::where('user_penerima_id', $user->id)
                ->orWhere('divisi_penerima_id', $user->divisi_id)
                ->pluck('surat_masuk_id')
                ->unique();

            $totalSuratMasuk = $disposisiSuratIds->count();
            $totalSuratKeluar = 0; // Role ini tidak terkait langsung dengan surat keluar
            $totalDokumen = 0; // Role ini tidak terkait langsung dengan dokumen
            $totalDisposisi = Disposisi::where('user_penerima_id', $user->id)
                ->orWhere('divisi_penerima_id', $user->divisi_id)
                ->count();
        } elseif ($user->isOperator() && $user->jurusan_id) {
            // Operator melihat data yang terkait dengan jurusannya.
            $totalSuratMasuk = SuratMasuk::where('jurusan_id', $user->jurusan_id)->count();
            $totalSuratKeluar = SuratKeluar::where('jurusan_id', $user->jurusan_id)->count();
            $totalDokumen = Dokumen::where('jurusan_id', $user->jurusan_id)->count();
            $totalDisposisi = 0;
        } else {
            // Default jika role tidak terdefinisi.
            return [0, 0, 0, 0];
        }
        return [$totalSuratMasuk, $totalSuratKeluar, $totalDokumen, $totalDisposisi];
    }

    /**
     * Mengambil data notifikasi (untuk badge dan dropdown header) berdasarkan role user.
     */
    private function getNotifications($user): array
    {
        // Inisialisasi dengan struktur yang benar
        $notifications = [
            'suratMasukCount' => 0,
            'suratMasukItems' => collect(),
            'disposisiCount' => 0,
            'disposisiItems' => collect(),
            // Tambahkan untuk surat keluar jika diperlukan
            'suratKeluarCount' => 0,
            'suratKeluarItems' => collect(),
        ];

        if ($user->isSekretaris()) {
            $query = SuratMasuk::whereIn('status_surat', ['Diajukan']);
            $notifications['suratMasukCount'] = $query->count();
            $notifications['suratMasukItems'] = $query->latest()->take(5)->get();
        } elseif ($user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang()) {
            $query = Disposisi::with('suratMasuk.user', 'userPemberi')
                ->where(function ($q) use ($user) {
                    $q->where('user_penerima_id', $user->id)
                        ->orWhere('divisi_penerima_id', $user->divisi_id);
                })
                ->where('status_disposisi', 'Baru');

            $count = $query->count();
            // PERBAIKAN: Hitung notifikasi untuk kedua kartu
            $notifications['disposisiCount'] = $count;
            $notifications['suratMasukCount'] = $count; // <-- Tambahkan ini agar badge di kartu Surat Masuk muncul

            $notifications['disposisiItems'] = $query->latest()->take(5)->get();
        } elseif ($user->isOperator()) {
            $query = SuratMasuk::where('user_id', $user->id)->where('status_surat', 'Ditolak');
            $notifications['suratMasukCount'] = $query->count();
            $notifications['suratMasukItems'] = $query->latest()->take(5)->get();
        }

        return $notifications;
    }

    /**
     * Mengambil daftar arsip terbaru untuk ditampilkan di tabel dashboard,
     * disesuaikan dengan role pengguna.
     */
    private function getRecentItems($user): array
    {
        // Default query untuk Admin, Sekretaris, dan Pimpinan
        $suratMasukQuery = SuratMasuk::query();
        $suratKeluarQuery = SuratKeluar::query();
        $dokumenQuery = Dokumen::query();

        if ($user->isOperator() && $user->jurusan_id) {
            // Operator hanya melihat arsip dari jurusannya
            $suratMasukQuery->where('jurusan_id', $user->jurusan_id);
            $suratKeluarQuery->where('jurusan_id', $user->jurusan_id);
            $dokumenQuery->where('jurusan_id', $user->jurusan_id);
        } elseif ($user->isKepalaLembaga() || $user->isKepalaBidang()) {
            $disposisiSuratIds = Disposisi::where('user_penerima_id', $user->id)
                ->orWhere('divisi_penerima_id', $user->divisi_id)
                ->pluck('surat_masuk_id')
                ->unique();

            $suratMasukQuery->whereIn('id', $disposisiSuratIds);

            // Batasi agar tidak ada surat keluar atau dokumen yang tampil untuk role ini
            $suratKeluarQuery->whereRaw('1 = 0'); // Query yang tidak akan mengembalikan hasil
            $dokumenQuery->whereRaw('1 = 0'); // Query yang tidak akan mengembalikan hasil
        }

        return [
            'suratMasuk' => $suratMasukQuery->with(['jurusan', 'user'])->latest()->take(5)->get(),
            'suratKeluar' => $suratKeluarQuery->with(['jurusan', 'user'])->latest()->take(5)->get(),
            'dokumen' => $dokumenQuery->with(['kategori', 'user'])->latest()->take(5)->get(),
        ];
    }
}
