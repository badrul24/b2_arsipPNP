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
            $totalDisposisi = Disposisi::where('isi_disposisi', '!=', '[AUTO] Disposisi otomatis dari sekretaris ke pimpinan')->count();
        } elseif ($user->isKepalaLembaga() || $user->isKepalaBidang()) {
            $disposisiSuratIds = Disposisi::where('user_penerima_id', $user->id)
                ->orWhere('divisi_penerima_id', $user->divisi_id)
                ->where('isi_disposisi', '!=', '[AUTO] Disposisi otomatis dari sekretaris ke pimpinan')
                ->pluck('surat_masuk_id')
                ->unique();

            $totalSuratMasuk = $disposisiSuratIds->count();
            $totalSuratKeluar = SuratKeluar::where('penerima', $user->name)->count();
            $totalDokumen = 0;
            $totalDisposisi = Disposisi::where('user_penerima_id', $user->id)
                ->orWhere('divisi_penerima_id', $user->divisi_id)
                ->where('isi_disposisi', '!=', '[AUTO] Disposisi otomatis dari sekretaris ke pimpinan')
                ->count();
        } elseif ($user->isOperator() && $user->jurusan_id) {
            // Untuk operator, jumlah surat masuk = semua surat masuk yang dibuat oleh operator
            $totalSuratMasuk = SuratMasuk::where('user_id', $user->id)->count();
            $totalSuratKeluar = SuratKeluar::where('jurusan_id', $user->jurusan_id)->count();
            $totalDokumen = Dokumen::where('jurusan_id', $user->jurusan_id)->count();
            $totalDisposisi = 0;
        } else {
            // Untuk penerima disposisi (user lain)
            $suratMasukIds = Disposisi::where('user_penerima_id', $user->id)
                ->whereIn('status_disposisi', ['Baru', 'Diterima'])
                ->pluck('surat_masuk_id')
                ->unique();
            $suratMasukItems = SuratMasuk::whereIn('id', $suratMasukIds)->latest()->take(5)->get();
            $notifications['suratMasukCount'] = $suratMasukItems->count();
            $notifications['suratMasukItems'] = $suratMasukItems;
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
            'suratKeluarCount' => 0,
            'suratKeluarItems' => collect(),
        ];

        if ($user->isSekretaris()) {
            $query = SuratMasuk::whereIn('status_surat', ['Diajukan']);
            $notifications['suratMasukCount'] = $query->count();
            $notifications['suratMasukItems'] = $query->latest()->take(5)->get();
        } elseif ($user->isPimpinan()) {
            // Notifikasi surat masuk status Diproses untuk pimpinan
            $query = \App\Models\SuratMasuk::where('status_surat', 'Diproses');
            $notifications['suratMasukCount'] = $query->count();
            $notifications['suratMasukItems'] = $query->latest()->take(5)->get();
            $query = Disposisi::with('suratMasuk.user', 'userPemberi')
                ->where(function ($q) use ($user) {
                    $q->where('user_penerima_id', $user->id)
                        ->orWhere('divisi_penerima_id', $user->divisi_id);
                })
                ->where('status_disposisi', 'Baru')
                ->where('isi_disposisi', '!=', '[AUTO] Disposisi otomatis dari sekretaris ke pimpinan');

            $count = $query->count();
            $notifications['disposisiCount'] = $count;
            $notifications['disposisiItems'] = $query->latest()->take(5)->get();
        } elseif ($user->isKepalaLembaga() || $user->isKepalaBidang()) {
            // Notifikasi surat masuk dari disposisi untuk kepala lembaga/bidang
            $disposisi = Disposisi::with('suratMasuk')
                ->where(function ($q) use ($user) {
                    $q->where('user_penerima_id', $user->id)
                        ->orWhere('divisi_penerima_id', $user->divisi_id);
                })
                ->where('status_disposisi', 'Baru')
                ->where('isi_disposisi', '!=', '[AUTO] Disposisi otomatis dari sekretaris ke pimpinan')
                ->latest()->take(10)->get();
            $suratMasukItems = $disposisi->pluck('suratMasuk')->filter()->unique('id')->take(5);
            $notifications['suratMasukCount'] = $suratMasukItems->count();
            $notifications['suratMasukItems'] = $suratMasukItems;
            $notifications['disposisiCount'] = $disposisi->count();
            $notifications['disposisiItems'] = $disposisi;
        } elseif ($user->isOperator()) {
            $query = SuratMasuk::where('user_id', $user->id)->where('status_surat', 'Ditolak');
            $notifications['suratMasukCount'] = $query->count();
            $notifications['suratMasukItems'] = $query->latest()->take(5)->get();
        } else {
            // Untuk penerima disposisi (user lain)
            $disposisi = Disposisi::with('suratMasuk')
                ->where('user_penerima_id', $user->id)
                ->whereIn('status_disposisi', ['Baru', 'Diterima'])
                ->where('isi_disposisi', '!=', '[AUTO] Disposisi otomatis dari sekretaris ke pimpinan')
                ->latest()->take(10)->get();
            $suratMasukItems = $disposisi->pluck('suratMasuk')->filter()->unique('id')->take(5);
            $notifications['suratMasukCount'] = $suratMasukItems->count();
            $notifications['suratMasukItems'] = $suratMasukItems;
        }

        // Notifikasi untuk surat keluar yang diterima user (status Baru/Terkirim)
        $skQuery = \App\Models\SuratKeluar::where('penerima', $user->name)
            ->whereIn('status_surat', ['Baru', 'Terkirim']);
        $notifications['suratKeluarCount'] = $skQuery->count();
        $notifications['suratKeluarItems'] = $skQuery->latest()->take(5)->get();

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
