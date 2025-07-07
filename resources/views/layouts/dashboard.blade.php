@extends('layouts.index')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
            <p class="mt-1 text-sm text-gray-500">Selamat datang di Manajemen Arsip Politeknik Negeri Padang</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer" onclick="document.getElementById('arsip-terbaru').scrollIntoView({ behavior: 'smooth' });">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-primary-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Arsip</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalArsip) }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('surat_masuk.index') }}'">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-green-100 rounded-full relative">
                    @if($notifications['suratMasuk'] > 0)
                        <div class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold">
                            {{ $notifications['suratMasuk'] > 99 ? '99+' : $notifications['suratMasuk'] }}
                        </div>
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Surat Masuk</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalSuratMasuk) }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('surat_keluar.index') }}'">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-blue-100 rounded-full relative">
                    @if(isset($notifications['suratKeluar']) && $notifications['suratKeluar'] > 0)
                        <div class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold">
                            {{ $notifications['suratKeluar'] > 99 ? '99+' : $notifications['suratKeluar'] }}
                        </div>
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Surat Keluar</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalSuratKeluar) }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('disposisi.index') }}'">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-yellow-100 rounded-full relative">
                    @if($notifications['disposisi'] > 0)
                        <div class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold">
                            {{ $notifications['disposisi'] > 99 ? '99+' : $notifications['disposisi'] }}
                        </div>
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Disposisi</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalDisposisi) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Chart -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Statistik Arsip</h3>
            </div>
            <div>
                <canvas id="arsipChart" height="300"></canvas>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Distribusi Arsip</h3>
            </div>
            <div class="flex items-center justify-center">
                <div class="w-64 h-64">
                    <canvas id="distributionChart"></canvas>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-2 bg-primary-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Surat Masuk ({{ $totalArsip > 0 ? round(($totalSuratMasuk / $totalArsip) * 100) : 0 }}%)</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-2 bg-blue-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Surat Keluar ({{ $totalArsip > 0 ? round(($totalSuratKeluar / $totalArsip) * 100) : 0 }}%)</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-2 bg-yellow-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Dokumen ({{ $totalArsip > 0 ? round(($totalDokumen / $totalArsip) * 100) : 0 }}%)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Archives -->
    <div id="arsip-terbaru" class="bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Arsip Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">No. Arsip</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Judul</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Jenis</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $allRecent = collect();
                        
                        // Gabungkan surat masuk
                        foreach($recentSuratMasuk as $surat) {
                            $allRecent->push([
                                'id' => $surat->id,
                                'nomor' => $surat->nomor_agenda,
                                'judul' => $surat->perihal,
                                'jenis' => 'Surat Masuk',
                                'tanggal' => $surat->created_at,
                                'status' => $surat->status_surat,
                                'route' => 'surat_masuk.index',
                                'user' => $surat->user->name ?? '-',
                                'jurusan' => $surat->jurusan->nama_jurusan ?? '-'
                            ]);
                        }
                        
                        // Gabungkan surat keluar
                        foreach($recentSuratKeluar as $surat) {
                            $allRecent->push([
                                'id' => $surat->id,
                                'nomor' => $surat->nomor_agenda,
                                'judul' => $surat->perihal,
                                'jenis' => 'Surat Keluar',
                                'tanggal' => $surat->created_at,
                                'status' => $surat->status_surat,
                                'route' => 'surat_keluar.index',
                                'user' => $surat->user->name ?? '-',
                                'jurusan' => $surat->jurusan->nama_jurusan ?? '-'
                            ]);
                        }
                        
                        // Gabungkan dokumen
                        foreach($recentDokumen as $dokumen) {
                            $allRecent->push([
                                'id' => $dokumen->id,
                                'nomor' => $dokumen->nomor_surat ?? '-',
                                'judul' => $dokumen->judul,
                                'jenis' => 'Dokumen',
                                'tanggal' => $dokumen->created_at,
                                'status' => $dokumen->status,
                                'route' => 'dokumen.index',
                                'user' => $dokumen->user->name ?? '-',
                                'kategori' => $dokumen->kategori->nama_kategori ?? '-'
                            ]);
                        }
                        
                        // Urutkan berdasarkan tanggal terbaru dan ambil 5 teratas
                        $allRecent = $allRecent->sortByDesc('tanggal')->values();
                        // Pagination manual jika total arsip > 10
                        $perPage = 5;
                        $currentPage = request()->get('page', 1);
                        $pagedRecent = new Illuminate\Pagination\LengthAwarePaginator(
                            $allRecent->forPage($currentPage, $perPage),
                            $allRecent->count(),
                            $perPage,
                            $currentPage,
                            ['path' => request()->url(), 'query' => request()->query()]
                        );
                    @endphp
                    
                    @php $isOperator = Auth::user() && Auth::user()->isOperator(); @endphp
                    
                    @forelse($pagedRecent as $item)
                        @if($item['jenis'] === 'Dokumen')
                            @if($isOperator)
                                <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route($item['route']) }}'">
                            @else
                                <tr>
                            @endif
                        @else
                            <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route($item['route']) }}'">
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $item['nomor'] }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $item['judul'] }}</div>
                            <div class="text-xs text-gray-500">
                                @if(isset($item['jurusan']))
                                    Jurusan: {{ $item['jurusan'] }}
                                @elseif(isset($item['kategori']))
                                    Kategori: {{ $item['kategori'] }}
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item['jenis'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item['tanggal']->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = [
                                    'Diajukan' => 'bg-yellow-100 text-yellow-800',
                                    'Diverifikasi' => 'bg-blue-100 text-blue-800',
                                    'Diproses' => 'bg-orange-100 text-orange-800',
                                    'Ditolak' => 'bg-red-100 text-red-800',
                                    'Disetujui' => 'bg-green-100 text-green-800',
                                    'Terkirim' => 'bg-indigo-100 text-indigo-800',
                                    'Baru' => 'bg-purple-100 text-purple-800',
                                    'Dibaca' => 'bg-blue-100 text-blue-800',
                                    'Selesai' => 'bg-teal-100 text-teal-800',
                                    'Diarsipkan' => 'bg-gray-500 text-white',
                                    'Draft' => 'bg-gray-100 text-gray-800',
                                    'Diterima' => 'bg-green-100 text-green-800',
                                    'Aktif' => 'bg-green-100 text-green-800',
                                    'Inaktif' => 'bg-yellow-100 text-yellow-800',
                                    'Musnah' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $statusClass[$item['status']] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $item['status'] }}
                            </span>
                        </td>
                        @if($item['jenis'] === 'Dokumen' && !$isOperator)
                        </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada arsip terbaru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($pagedRecent->lastPage() > 1)
                <div class="px-6 py-2">
                    {{ $pagedRecent->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Chart Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Line Chart
        const arsipCtx = document.getElementById('arsipChart').getContext('2d');
        const arsipChart = new Chart(arsipCtx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                datasets: [
                    {
                        label: 'Surat Masuk',
                        data: [{{ $totalSuratMasuk }}, {{ $totalSuratMasuk }}, {{ $totalSuratMasuk }}, {{ $totalSuratMasuk }}, {{ $totalSuratMasuk }}, {{ $totalSuratMasuk }}],
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Surat Keluar',
                        data: [{{ $totalSuratKeluar }}, {{ $totalSuratKeluar }}, {{ $totalSuratKeluar }}, {{ $totalSuratKeluar }}, {{ $totalSuratKeluar }}, {{ $totalSuratKeluar }}],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Pie Chart
        const distributionCtx = document.getElementById('distributionChart').getContext('2d');
        const distributionChart = new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Surat Masuk', 'Surat Keluar', 'Dokumen'],
                datasets: [{
                    data: [{{ $totalSuratMasuk }}, {{ $totalSuratKeluar }}, {{ $totalDokumen }}],
                    backgroundColor: [
                        '#0ea5e9',
                        '#3b82f6',
                        '#eab308'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endsection
