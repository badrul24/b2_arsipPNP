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
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        // Statistik berdasarkan role user
        list(
            $totalSuratMasuk,
            $totalSuratKeluar,
            $totalDokumen,
            $totalDisposisi,
            $suratMasukByStatus,
            $suratKeluarByStatus,
            $dokumenByStatus
        ) = $this->getStatistics($user);

        // Arsip terbaru untuk tabel dashboard (selalu ambil 3 terbaru per jenis)
        $recentSuratMasuk = SuratMasuk::with(['jurusan', 'user'])->latest()->take(3)->get();
        $recentSuratKeluar = SuratKeluar::with(['jurusan', 'user'])->latest()->take(3)->get();
        $recentDokumen = Dokumen::with(['kategori', 'kode', 'user'])->latest()->take(3)->get();

        // Notifikasi berdasarkan role (gunakan variabel notif* khusus untuk header)
        $notifications = [];
        $notifSuratMasuk = collect();
        $notifSuratKeluar = collect();
        $notifDisposisi = collect();
        $this->setNotifications($user, $notifications, $notifSuratMasuk, $notifSuratKeluar, $notifDisposisi);

        $totalArsip = $totalSuratMasuk + $totalSuratKeluar + $totalDokumen;

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
            'recentDokumen',
            'notifSuratMasuk',
            'notifSuratKeluar',
            'notifDisposisi'
        ));
    }

    private function getStatistics($user)
    {
        if ($user->isAdmin()) {
            return [
                SuratMasuk::count(),
                SuratKeluar::count(),
                Dokumen::count(),
                Disposisi::count(),
                SuratMasuk::select('status_surat', DB::raw('count(*) as total'))->groupBy('status_surat')->get(),
                SuratKeluar::select('status_surat', DB::raw('count(*) as total'))->groupBy('status_surat')->get(),
                Dokumen::select('status', DB::raw('count(*) as total'))->groupBy('status')->get(),
            ];
        } elseif ($user->isOperator() && $user->jurusan_id) {
            return [
                SuratMasuk::where('jurusan_id', $user->jurusan_id)->count(),
                SuratKeluar::where('jurusan_id', $user->jurusan_id)->count(),
                Dokumen::where('jurusan_id', $user->jurusan_id)->count(),
                Disposisi::whereHas('suratMasuk', function($query) use ($user) {
                    $query->where('jurusan_id', $user->jurusan_id);
                })->count(),
                SuratMasuk::where('jurusan_id', $user->jurusan_id)->select('status_surat', DB::raw('count(*) as total'))->groupBy('status_surat')->get(),
                SuratKeluar::where('jurusan_id', $user->jurusan_id)->select('status_surat', DB::raw('count(*) as total'))->groupBy('status_surat')->get(),
                Dokumen::where('jurusan_id', $user->jurusan_id)->select('status', DB::raw('count(*) as total'))->groupBy('status')->get(),
            ];
        } else {
            return [
                SuratMasuk::count(),
                SuratKeluar::count(),
                Dokumen::count(),
                Disposisi::count(),
                SuratMasuk::select('status_surat', DB::raw('count(*) as total'))->groupBy('status_surat')->get(),
                SuratKeluar::select('status_surat', DB::raw('count(*) as total'))->groupBy('status_surat')->get(),
                Dokumen::select('status', DB::raw('count(*) as total'))->groupBy('status')->get(),
            ];
        }
    }

    private function setNotifications($user, &$notifications, &$notifSuratMasuk, &$notifSuratKeluar, &$notifDisposisi)
    {
        if ($user->isSekretaris()) {
            $notifications['suratMasuk'] = SuratMasuk::whereIn('status_surat', ['Diajukan', 'Ditolak'])->count();
            $notifSuratMasuk = SuratMasuk::whereIn('status_surat', ['Diajukan', 'Ditolak'])->latest()->take(5)->get();
            $notifications['disposisi'] = 0;
            $notifications['suratKeluar'] = SuratKeluar::where('penerima', $user->name)
                ->whereIn('status_surat', ['Baru', 'Terkirim'])
                ->count();
            $notifSuratKeluar = SuratKeluar::where('penerima', $user->name)
                ->whereIn('status_surat', ['Baru', 'Terkirim'])
                ->latest()
                ->take(5)
                ->get();
        } elseif ($user->isPimpinan()) {
            $notifications['suratMasuk'] = SuratMasuk::where('status_surat', 'Diproses')->count();
            $notifSuratMasuk = SuratMasuk::where('status_surat', 'Diproses')->latest()->take(5)->get();
            $notifications['disposisi'] = 0;
            $notifications['suratKeluar'] = SuratKeluar::where('penerima', $user->name)->whereIn('status_surat', ['Baru', 'Terkirim'])->count();
            $notifSuratKeluar = SuratKeluar::where('penerima', $user->name)->whereIn('status_surat', ['Baru', 'Terkirim'])->latest()->take(5)->get();
        } elseif ($user->isKepalaLembaga() || $user->isKepalaBidang()) {
            $notifDisposisi = Disposisi::where('user_penerima_id', $user->id)->where('status_disposisi', 'Baru')->latest()->take(5)->get();
            $notifications['disposisi'] = $notifDisposisi->count();
            $notifications['suratMasuk'] = Disposisi::where('user_penerima_id', $user->id)->where('status_disposisi', 'Baru')->count();
            $notifications['suratKeluar'] = SuratKeluar::where('penerima', $user->name)->whereIn('status_surat', ['Baru', 'Terkirim'])->count();
            $notifSuratKeluar = SuratKeluar::where('penerima', $user->name)->whereIn('status_surat', ['Baru', 'Terkirim'])->latest()->take(5)->get();
        } elseif ($user->isAdmin()) {
            $notifications['suratMasuk'] = SuratMasuk::whereIn('status_surat', ['Diajukan', 'Ditolak', 'Diproses'])->count();
            $notifSuratMasuk = SuratMasuk::whereIn('status_surat', ['Diajukan', 'Ditolak', 'Diproses'])->latest()->take(5)->get();
            $notifications['disposisi'] = Disposisi::where('status_disposisi', 'Baru')->count();
            $notifDisposisi = Disposisi::where('status_disposisi', 'Baru')->latest()->take(5)->get();
            $notifications['suratKeluar'] = 0;
        } elseif ($user->isOperator()) {
            $notifications['suratMasuk'] = 0;
            $notifications['disposisi'] = 0;
            $notifications['suratKeluar'] = 0;
        } else {
            $notifications['suratMasuk'] = 0;
            $notifications['disposisi'] = 0;
            $notifications['suratKeluar'] = 0;
        }
    }
} 