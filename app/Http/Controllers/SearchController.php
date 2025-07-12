<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Dokumen;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return view('search', [
                'q' => '',
                'results' => collect(),
                'totalResults' => 0
            ]);
        }

        $results = collect();
        $totalResults = 0;

        // Debug: Check if we have any berita at all
        $totalBerita = Berita::count();
        Log::info('Total berita in database: ' . $totalBerita);

        // Simple search in Berita - just search in judul_berita first
        $beritas = Berita::with(['user', 'kategori'])
            ->where('judul_berita', 'like', "%{$query}%")
            ->latest()
            ->take(5)
            ->get();

        Log::info('Search query: ' . $query);
        Log::info('Berita found: ' . $beritas->count());

        $beritas = $beritas->map(function ($berita) {
            return [
                'type' => 'berita',
                'title' => $berita->judul_berita,
                'description' => substr(strip_tags($berita->isi_berita), 0, 150) . '...',
                'url' => route('berita.show', $berita),
                'date' => $berita->created_at->format('d M Y'),
                'category' => $berita->kategori->nama_kategori ?? 'Tidak ada kategori',
                'author' => $berita->user->name ?? 'Tidak diketahui'
            ];
        });

        $results = $results->merge($beritas);
        $totalResults += $beritas->count();

        // Search in Dokumen (only if user is authenticated)
        if (Auth::check()) {
            $user = Auth::user();
            $dokumenQuery = Dokumen::with(['kategori', 'kode', 'lokasi', 'retensi', 'jurusan', 'user']);

            // Filter berdasarkan role
            if ($user->isOperator() || $user->isPimpinan()) {
                $dokumenQuery->where('jurusan_id', $user->jurusan_id);
            }

            $dokumens = $dokumenQuery
                ->where(function ($q) use ($query) {
                    $q->where('nomor_surat', 'like', "%{$query}%")
                      ->orWhere('judul', 'like', "%{$query}%")
                      ->orWhere('keterangan', 'like', "%{$query}%")
                      ->orWhereHas('kategori', function ($q) use ($query) {
                          $q->where('nama_kategori', 'like', "%{$query}%");
                      })
                      ->orWhereHas('kode', function ($q) use ($query) {
                          $q->where('nama_kode', 'like', "%{$query}%");
                      });
                })
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($dokumen) {
                    return [
                        'type' => 'dokumen',
                        'title' => $dokumen->judul,
                        'description' => 'Nomor: ' . $dokumen->nomor_surat . ' - ' . substr($dokumen->keterangan, 0, 100) . '...',
                        'url' => route('dokumen.show', $dokumen),
                        'date' => $dokumen->created_at->format('d M Y'),
                        'category' => $dokumen->kategori->nama_kategori ?? 'Tidak ada kategori',
                        'author' => $dokumen->user->name ?? 'Tidak diketahui'
                    ];
                });

            $results = $results->merge($dokumens);
            $totalResults += $dokumens->count();
        }

        // Search in Surat Masuk (only if user is authenticated)
        if (Auth::check()) {
            $user = Auth::user();
            $suratMasukQuery = SuratMasuk::with(['jurusan', 'user']);

            // Filter berdasarkan role
            if ($user->isAdmin()) {
                // Admin melihat semua surat
            } elseif ($user->isSekretaris()) {
                $suratMasukQuery->whereIn('status_surat', [
                    'Diajukan', 'Diverifikasi', 'Ditolak', 'Diproses', 
                    'Disetujui', 'Terkirim', 'Baru', 'Dibaca', 'Selesai', 'Diarsipkan'
                ]);
            } elseif ($user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang()) {
                $suratMasukQuery->whereIn('status_surat', ['Diproses', 'Terkirim', 'Dibaca']);
            } elseif ($user->isOperator() && $user->jurusan_id) {
                $suratMasukQuery->where('user_id', $user->id)
                    ->where('jurusan_id', $user->jurusan_id);
            } else {
                // Untuk penerima disposisi
                $disposisiSuratIds = \App\Models\Disposisi::where('user_penerima_id', $user->id)
                    ->whereIn('status_disposisi', ['Baru', 'Diterima'])
                    ->pluck('surat_masuk_id');
                $suratMasukQuery->whereIn('id', $disposisiSuratIds);
            }

            $suratMasuks = $suratMasukQuery
                ->where(function ($q) use ($query) {
                    $q->where('nomor_agenda', 'like', "%{$query}%")
                      ->orWhere('nomor_surat_pengirim', 'like', "%{$query}%")
                      ->orWhere('perihal', 'like', "%{$query}%")
                      ->orWhere('keterangan', 'like', "%{$query}%")
                      ->orWhere('pengirim', 'like', "%{$query}%");
                })
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($surat) {
                    return [
                        'type' => 'surat_masuk',
                        'title' => $surat->perihal,
                        'description' => 'Nomor: ' . $surat->nomor_agenda . ' - Pengirim: ' . $surat->pengirim,
                        'url' => route('surat_masuk.edit', $surat),
                        'date' => $surat->tanggal_surat_pengirim ? \Carbon\Carbon::parse($surat->tanggal_surat_pengirim)->format('d M Y') : 'Tidak ada tanggal',
                        'category' => 'Surat Masuk',
                        'author' => $surat->user->name ?? 'Tidak diketahui'
                    ];
                });

            $results = $results->merge($suratMasuks);
            $totalResults += $suratMasuks->count();
        }

        // Search in Surat Keluar (only if user is authenticated)
        if (Auth::check()) {
            $user = Auth::user();
            $suratKeluarQuery = SuratKeluar::with(['jurusan', 'divisi', 'user']);

            // Filter berdasarkan role
            if ($user->isAdmin()) {
                // Admin melihat semua surat keluar
            } else {
                // User lain melihat surat keluar yang penerimanya adalah dirinya ATAU yang dia buat sendiri
                $suratKeluarQuery->where(function($q) use ($user) {
                    $q->where('penerima', $user->name)
                      ->orWhere('user_id', $user->id);
                });
            }

            $suratKeluars = $suratKeluarQuery
                ->where(function ($q) use ($query) {
                    $q->where('nomor_agenda', 'like', "%{$query}%")
                      ->orWhere('nomor_surat_keluar', 'like', "%{$query}%")
                      ->orWhere('perihal', 'like', "%{$query}%")
                      ->orWhere('tujuan_surat', 'like', "%{$query}%")
                      ->orWhere('pengirim', 'like', "%{$query}%")
                      ->orWhere('penerima', 'like', "%{$query}%");
                })
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($surat) {
                    return [
                        'type' => 'surat_keluar',
                        'title' => $surat->perihal,
                        'description' => 'Nomor: ' . $surat->nomor_agenda . ' - Tujuan: ' . $surat->tujuan_surat,
                        'url' => route('surat_keluar.edit', $surat),
                        'date' => $surat->tanggal_surat ? \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') : 'Tidak ada tanggal',
                        'category' => 'Surat Keluar',
                        'author' => $surat->user->name ?? 'Tidak diketahui'
                    ];
                });

            $results = $results->merge($suratKeluars);
            $totalResults += $suratKeluars->count();
        }

        // Search in Jurusan
        $jurusans = Jurusan::where(function ($q) use ($query) {
            $q->where('nama_jurusan', 'like', "%{$query}%")
              ->orWhere('kode_jurusan', 'like', "%{$query}%")
              ->orWhere('keterangan', 'like', "%{$query}%");
        })
        ->latest()
        ->take(3)
        ->get()
        ->map(function ($jurusan) {
            return [
                'type' => 'jurusan',
                'title' => $jurusan->nama_jurusan,
                'description' => 'Kode: ' . $jurusan->kode_jurusan . ' - ' . substr($jurusan->keterangan, 0, 100) . '...',
                'url' => route('jurusan.show', $jurusan),
                'date' => $jurusan->created_at->format('d M Y'),
                'category' => 'Jurusan',
                'author' => 'Sistem'
            ];
        });

        $results = $results->merge($jurusans);
        $totalResults += $jurusans->count();

        // Sort results by date (newest first)
        $results = $results->sortByDesc('date')->values();

        return view('landing_page.search', [
            'q' => $query,
            'results' => $results,
            'totalResults' => $totalResults
        ]);
    }
} 