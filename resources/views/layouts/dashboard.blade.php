@extends('layouts.index')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
            <p class="mt-1 text-sm text-gray-500">Selamat datang di Manajemen Arsip Politeknik Negeri Padang</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer" onclick="document.getElementById('arsip-terbaru').scrollIntoView({ behavior: 'smooth' });">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-blue-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
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
                    @if(($notifications['suratMasukCount'] ?? 0) > 0)
                        <div class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold">
                            {{ $notifications['suratMasukCount'] > 99 ? '99+' : $notifications['suratMasukCount'] }}
                        </div>
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Surat Masuk</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalSuratMasuk) }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('surat_keluar.index') }}'">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-purple-100 rounded-full relative">
                    @if(($notifications['suratKeluarCount'] ?? 0) > 0)
                        <div class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold">
                            {{ $notifications['suratKeluarCount'] > 99 ? '99+' : $notifications['suratKeluarCount'] }}
                        </div>
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
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
                    @if(($notifications['disposisiCount'] ?? 0) > 0)
                        <div class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold">
                            {{ $notifications['disposisiCount'] > 99 ? '99+' : $notifications['disposisiCount'] }}
                        </div>
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Disposisi</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalDisposisi) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Arsip</h3>
            <div><canvas id="arsipChart" height="300"></canvas></div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Distribusi Arsip</h3>
            <div class="flex items-center justify-center h-64"><canvas id="distributionChart"></canvas></div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-2 bg-green-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Surat Masuk ({{ $totalArsip > 0 ? round(($totalSuratMasuk / $totalArsip) * 100) : 0 }}%)</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-2 bg-purple-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Surat Keluar ({{ $totalArsip > 0 ? round(($totalSuratKeluar / $totalArsip) * 100) : 0 }}%)</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-2 bg-yellow-500 rounded-full"></span>
                    <span class="text-sm text-gray-600">Dokumen ({{ $totalArsip > 0 ? round(($totalDokumen / $totalArsip) * 100) : 0 }}%)</span>
                </div>
            </div>
        </div>
    </div>

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
                        $allRecentItems = collect($recentItems['suratMasuk'])
                            ->map(fn($item) => (object)[
                                'nomor_arsip' => $item->nomor_agenda, 'judul_arsip' => $item->perihal, 'jenis_arsip' => 'Surat Masuk',
                                'tanggal_arsip' => $item->created_at, 'status_arsip' => $item->status_surat, 'route' => route('surat_masuk.index')
                            ])
                            ->merge($recentItems['suratKeluar']->map(fn($item) => (object)[
                                'nomor_arsip' => $item->nomor_agenda, 'judul_arsip' => $item->perihal, 'jenis_arsip' => 'Surat Keluar',
                                'tanggal_arsip' => $item->created_at, 'status_arsip' => $item->status_surat, 'route' => route('surat_keluar.index')
                            ]))
                            ->merge($recentItems['dokumen']->map(fn($item) => (object)[
                                'nomor_arsip' => $item->nomor_surat ?? '-', 'judul_arsip' => $item->judul, 'jenis_arsip' => 'Dokumen',
                                'tanggal_arsip' => $item->created_at, 'status_arsip' => $item->status, 'route' => route('dokumen.index')
                            ]))
                            ->sortByDesc('tanggal_arsip');
                    @endphp

                    @forelse($allRecentItems as $item)
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ $item->route }}'">
                            <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">{{ $item->nomor_arsip }}</div></td>
                            <td class="px-6 py-4"><div class="text-sm text-gray-900">{{ $item->judul_arsip }}</div></td>
                            <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-900">{{ $item->jenis_arsip }}</div></td>
                            <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-900">{{ $item->tanggal_arsip->format('d M Y') }}</div></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = [
                                        'Diajukan' => 'bg-yellow-100 text-yellow-800', 'Diverifikasi' => 'bg-blue-100 text-blue-800',
                                        'Diproses' => 'bg-orange-100 text-orange-800', 'Ditolak' => 'bg-red-100 text-red-800',
                                        'Disetujui' => 'bg-green-100 text-green-800', 'Terkirim' => 'bg-indigo-100 text-indigo-800',
                                        'Baru' => 'bg-purple-100 text-purple-800', 'Dibaca' => 'bg-blue-100 text-blue-800',
                                        'Selesai' => 'bg-teal-100 text-teal-800', 'Diarsipkan' => 'bg-gray-500 text-white',
                                        'Draft' => 'bg-gray-100 text-gray-800', 'Diterima' => 'bg-green-100 text-green-800',
                                        'Aktif' => 'bg-green-100 text-green-800', 'Inaktif' => 'bg-yellow-100 text-yellow-800',
                                        'Musnah' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $statusClass[$item->status_arsip] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $item->status_arsip }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada arsip terbaru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Line Chart
        const arsipCtx = document.getElementById('arsipChart').getContext('2d');
        new Chart(arsipCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'], // Ganti dengan data dinamis jika perlu
                datasets: [{
                    label: 'Surat Masuk',
                    data: [{{ $totalSuratMasuk }}, 0, 0, 0, 0, 0], // Ganti dengan data per bulan jika ada
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.3, fill: true
                }, {
                    label: 'Surat Keluar',
                    data: [{{ $totalSuratKeluar }}, 0, 0, 0, 0, 0], // Ganti dengan data per bulan jika ada
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.3, fill: true
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, /* Opsi lain */ }
        });

        // Pie Chart
        const distributionCtx = document.getElementById('distributionChart').getContext('2d');
        new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Surat Masuk', 'Surat Keluar', 'Dokumen'],
                datasets: [{
                    data: [{{ $totalSuratMasuk }}, {{ $totalSuratKeluar }}, {{ $totalDokumen }}],
                    backgroundColor: ['#22c55e', '#8b5cf6', '#eab308'],
                    borderWidth: 0, hoverOffset: 4
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, cutout: '70%' }
        });
    });
</script>
@endsection