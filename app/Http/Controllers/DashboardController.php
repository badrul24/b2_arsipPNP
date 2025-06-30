<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Dokumen;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik berdasarkan role user
        if ($user->isAdmin()) {
            // Admin melihat semua data
            $totalSuratMasuk = SuratMasuk::count();
            $totalSuratKeluar = SuratKeluar::count();
            $totalDokumen = Dokumen::count();
            $totalDisposisi = Disposisi::count();
            
            // Surat masuk berdasarkan status
            $suratMasukByStatus = SuratMasuk::select('status_surat', DB::raw('count(*) as total'))
                ->groupBy('status_surat')
                ->get();
                
            // Surat keluar berdasarkan status
            $suratKeluarByStatus = SuratKeluar::select('status_surat', DB::raw('count(*) as total'))
                ->groupBy('status_surat')
                ->get();
                
            // Dokumen berdasarkan status
            $dokumenByStatus = Dokumen::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();
                
            // Arsip terbaru (gabungan surat masuk, surat keluar, dan dokumen)
            $recentSuratMasuk = SuratMasuk::with(['jurusan', 'user'])
                ->latest()
                ->take(3)
                ->get();
                
            $recentSuratKeluar = SuratKeluar::with(['jurusan', 'user'])
                ->latest()
                ->take(3)
                ->get();
                
            $recentDokumen = Dokumen::with(['kategori', 'kode', 'user'])
                ->latest()
                ->take(3)
                ->get();
                
        } elseif ($user->isOperator() && $user->jurusan_id) {
            // Operator hanya melihat data jurusannya
            $totalSuratMasuk = SuratMasuk::where('jurusan_id', $user->jurusan_id)->count();
            $totalSuratKeluar = SuratKeluar::where('jurusan_id', $user->jurusan_id)->count();
            $totalDokumen = Dokumen::where('jurusan_id', $user->jurusan_id)->count();
            $totalDisposisi = Disposisi::whereHas('suratMasuk', function($query) use ($user) {
                $query->where('jurusan_id', $user->jurusan_id);
            })->count();
            
            // Surat masuk berdasarkan status untuk jurusan
            $suratMasukByStatus = SuratMasuk::where('jurusan_id', $user->jurusan_id)
                ->select('status_surat', DB::raw('count(*) as total'))
                ->groupBy('status_surat')
                ->get();
                
            // Surat keluar berdasarkan status untuk jurusan
            $suratKeluarByStatus = SuratKeluar::where('jurusan_id', $user->jurusan_id)
                ->select('status_surat', DB::raw('count(*) as total'))
                ->groupBy('status_surat')
                ->get();
                
            // Dokumen berdasarkan status untuk jurusan
            $dokumenByStatus = Dokumen::where('jurusan_id', $user->jurusan_id)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();
                
            // Arsip terbaru untuk jurusan
            $recentSuratMasuk = SuratMasuk::with(['jurusan', 'user'])
                ->where('jurusan_id', $user->jurusan_id)
                ->latest()
                ->take(3)
                ->get();
                
            $recentSuratKeluar = SuratKeluar::with(['jurusan', 'user'])
                ->where('jurusan_id', $user->jurusan_id)
                ->latest()
                ->take(3)
                ->get();
                
            $recentDokumen = Dokumen::with(['kategori', 'kode', 'user'])
                ->where('jurusan_id', $user->jurusan_id)
                ->latest()
                ->take(3)
                ->get();
                
        } else {
            // User lain (Sekretaris, Pimpinan, dll)
            $totalSuratMasuk = SuratMasuk::count();
            $totalSuratKeluar = SuratKeluar::count();
            $totalDokumen = Dokumen::count();
            $totalDisposisi = Disposisi::count();
            
            // Surat masuk berdasarkan status
            $suratMasukByStatus = SuratMasuk::select('status_surat', DB::raw('count(*) as total'))
                ->groupBy('status_surat')
                ->get();
                
            // Surat keluar berdasarkan status
            $suratKeluarByStatus = SuratKeluar::select('status_surat', DB::raw('count(*) as total'))
                ->groupBy('status_surat')
                ->get();
                
            // Dokumen berdasarkan status
            $dokumenByStatus = Dokumen::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();
                
            // Arsip terbaru
            $recentSuratMasuk = SuratMasuk::with(['jurusan', 'user'])
                ->latest()
                ->take(3)
                ->get();
                
            $recentSuratKeluar = SuratKeluar::with(['jurusan', 'user'])
                ->latest()
                ->take(3)
                ->get();
                
            $recentDokumen = Dokumen::with(['kategori', 'kode', 'user'])
                ->latest()
                ->take(3)
                ->get();
        }

        // Total arsip
        $totalArsip = $totalSuratMasuk + $totalSuratKeluar + $totalDokumen;

        // Notifikasi berdasarkan role
        $notifications = [];
        
        if (
            $user->isSekretaris()
        ) {
            // Sekretaris: notifikasi surat yang perlu diverifikasi/dikembalikan
            $notifications['suratMasuk'] = SuratMasuk::whereIn('status_surat', ['Diajukan', 'Ditolak'])->count();
            $notifications['disposisi'] = 0; // Sekretaris tidak menerima disposisi
            $notifications['suratKeluar'] = 0; // Sekretaris tidak menerima surat keluar
        } elseif ($user->isPimpinan()) {
            // Pimpinan: notifikasi surat yang perlu diproses dan disposisi yang perlu dibuat
            $notifications['suratMasuk'] = SuratMasuk::where('status_surat', 'Diproses')->count();
            $notifications['disposisi'] = 0; // Pimpinan membuat disposisi, bukan menerima
            $notifications['suratKeluar'] = SuratKeluar::where('penerima', $user->name)
                ->whereIn('status_surat', ['Baru', 'Terkirim'])
                ->count();
        } elseif ($user->isKepalaLembaga() || $user->isKepalaBidang()) {
            // Kepala Lembaga/Bidang: bisa menerima disposisi dan menangani surat masuk
            // Cek disposisi baru untuk user ini
            $disposisiBaru = Disposisi::where('user_penerima_id', $user->id)
                ->where('status_disposisi', 'Baru')
                ->count();
            
            if ($disposisiBaru > 0) {
                $suratMasukIds = Disposisi::where('user_penerima_id', $user->id)
                    ->where('status_disposisi', 'Baru')
                    ->pluck('surat_masuk_id');
                $notifications['suratMasuk'] = count($suratMasukIds);
            } else {
                $notifications['suratMasuk'] = 0;
            }
            
            $notifications['disposisi'] = $disposisiBaru;
            $notifications['suratKeluar'] = SuratKeluar::where('penerima', $user->name)
                ->whereIn('status_surat', ['Baru', 'Terkirim'])
                ->count();
        } elseif ($user->isAdmin()) {
            // Admin: melihat semua notifikasi
            $notifications['suratMasuk'] = SuratMasuk::whereIn('status_surat', ['Diajukan', 'Ditolak', 'Diproses'])->count();
            $notifications['disposisi'] = Disposisi::where('status_disposisi', 'Baru')->count();
            $notifications['suratKeluar'] = 0; // Admin tidak menerima surat keluar
        } elseif ($user->isOperator()) {
            // Operator: tidak menerima notifikasi count karena surat masuk dan keluar berasal dari operator
            $notifications['suratMasuk'] = 0;
            $notifications['disposisi'] = 0;
            $notifications['suratKeluar'] = 0;
        } else {
            // User lain (termasuk penerima disposisi) - default case
            // Cek apakah user perlu menangani surat masuk (misalnya untuk role tertentu)
            $notifications['suratMasuk'] = 0;
            
            // Cek apakah user adalah penerima disposisi
            $disposisiBaru = Disposisi::where('user_penerima_id', $user->id)
                ->where('status_disposisi', 'Baru')
                ->count();
            $notifications['disposisi'] = $disposisiBaru;
            // Notifikasi surat keluar untuk penerima
            $notifications['suratKeluar'] = SuratKeluar::where('penerima', $user->name)
                ->whereIn('status_surat', ['Baru', 'Terkirim'])
                ->count();
        }

        return view('layouts.dashboard', compact(
            'totalArsip',
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalDokumen',
            'totalDisposisi',
            'notifications',
            'suratMasukByStatus',
            'suratKeluarByStatus',
            'dokumenByStatus',
            'recentSuratMasuk',
            'recentSuratKeluar',
            'recentDokumen'
        ));
    }
} 