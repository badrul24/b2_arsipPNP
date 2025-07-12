@extends('landing_page.user')
@section('title','Laporan Arsip')
@section('content')

<!-- Tailwind dan Chart.js -->
<script>
    tailwind.config = {
        safelist: [
            'text-primary-50', 'text-primary-100', 'text-primary-200', 'text-primary-300', 'text-primary-400',
            'text-primary-500', 'text-primary-600', 'text-primary-700', 'text-primary-800', 'text-primary-900',
            'bg-primary-50', 'bg-primary-100', 'bg-primary-200', 'bg-primary-300', 'bg-primary-400',
            'bg-primary-500', 'bg-primary-600', 'bg-primary-700', 'bg-primary-800', 'bg-primary-900',
        ],
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#d1d9e0',
                        100: '#b4c3d1',
                        200: '#96acc1',
                        300: '#7895b1',
                        400: '#5a7fa1',
                        500: '#3d6992',
                        600: '#2f5171',
                        700: '#223b55',
                        800: '#172a3d',
                        900: '#0e1b28',
                        950: '#080f15',
                    }
                }
            }
        }
    }
</script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Main Section -->
<section class="pt-28 bg-gray-200 min-h-screen">
    <!-- Header -->
    <div class="mb-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <h1 class="text-4xl font-bold text-primary-600">Laporan Data Arsip</h1>
        <nav class="text-sm text-gray-500 mt-2">
            <ol class="list-reset flex">
                <li><a href="{{ url('/') }}" class="text-primary-600 hover:underline">Beranda</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="#" class="text-primary-600 hover:underline">Arsip</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-primary-700 font-semibold">Laporan</li>
            </ol>
        </nav>
    </div>

    <!-- Main Content White Background -->
    <div class="w-full h-full bg-white py-8">
        <div class="flex flex-col lg:flex-row gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-16">
            <!-- Grafik -->
            <div class="w-full lg:w-2/3 bg-white shadow-lg rounded-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-primary-500 mb-4">Statistik Arsip</h2>
                <div class="h-[350px]">
                    <canvas id="arsipChart"></canvas>
                </div>
            </div>

            <!-- Ringkasan Arsip -->
            <div class="w-full lg:w-1/3 flex flex-col gap-4">
                @php
                    $dataArsip = [
                        ['label' => 'Arsip Aktif', 'value' => $aktif ?? 0],
                        ['label' => 'Arsip Inaktif', 'value' => $inaktif ?? 0],
                        ['label' => 'Arsip Musnah', 'value' => $musnah ?? 0],
                    ];
                    $totalArsip = $total ?? array_sum(array_column($dataArsip, 'value'));
                @endphp

                @foreach ($dataArsip as $arsip)
                    <div class="flex bg-white shadow border border-gray-200 rounded-lg overflow-hidden">
                        <div class="w-2/3 px-4 py-4 flex items-center">
                            <span class="text-lg font-medium text-primary-600">{{ $arsip['label'] }}</span>
                        </div>
                        <div class="w-1/3 bg-primary-500 text-white flex items-center justify-center text-2xl font-bold">
                            {{ $arsip['value'] }}
                        </div>
                    </div>
                @endforeach

                <!-- Total Jumlah Arsip -->
                <!-- Total Jumlah Arsip - Ditinggikan dan Dihiasi -->
                <div class="flex flex-col flex-1 justify-between bg-white-100 border border-gray-200 rounded-xl shadow-lg px-6 py-6 mt-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-primary-600 text-white p-3 rounded-full shadow-md">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10M4 18h6"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-primary-700">Total Jumlah Arsip</h3>
                            <p class="text-sm text-primary-600">Gabungan dari semua status arsip</p>
                        </div>
                    </div>
                    <div class="text-right mt-6">
                        <span class="text-4xl font-bold text-primary-800">{{ $totalArsip }}</span>
                        <p class="text-sm text-primary-600">data arsip tercatat</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
            <h2 class="text-2xl font-semibold text-primary-600 mb-4">Statistik Gabungan Arsip</h2>

            <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
                <div class="h-[500px]">
                    <canvas id="arsipGabunganChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Laporan Berdasarkan Kategori dan Status -->
        <!-- Ganti bagian ini dengan tampilan baru kategori -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
            <h2 class="text-2xl font-semibold text-primary-600 mb-4">Laporan Pengkategorian Arsip</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Bidang Fungsi -->
                <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-primary-700 mb-4">Berdasarkan Fungsi</h3>
                    <div class="space-y-2">
                        @foreach($statistikFungsi as $fungsi)
                            <div class="flex justify-between">
                                <span>{{ $fungsi['nama'] }}</span>
                                <span class="font-bold text-primary-600">{{ $fungsi['jumlah'] }}</span>
                            </div>
                        @endforeach
                        @if(empty($statistikFungsi))
                            <div class="text-gray-500 text-sm">Belum ada data kategori</div>
                        @endif
                    </div>
                </div>

                <!-- Jenis Arsip -->
                <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-primary-700 mb-4">Berdasarkan Jenis Arsip</h3>
                    <div class="space-y-2">
                        @foreach($statistikJenis as $jenis)
                            <div class="flex justify-between">
                                <span>{{ $jenis['nama'] }}</span>
                                <span class="font-bold text-primary-600">{{ $jenis['jumlah'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Retensi (Masa Simpan) -->
                <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-primary-700 mb-4">Berdasarkan Masa Simpan (Retensi)</h3>
                    <div class="space-y-2">
                        @foreach($statistikRetensi as $retensi)
                            <div class="flex justify-between">
                                <span>{{ $retensi['nama'] }}</span>
                                <span class="font-bold text-primary-600">{{ $retensi['jumlah'] }}</span>
                            </div>
                        @endforeach
                        @if(empty($statistikRetensi))
                            <div class="text-gray-500 text-sm">Belum ada data retensi</div>
                        @endif
                    </div>
                </div>

                <!-- Keamanan Arsip -->
                <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-primary-700 mb-4">Berdasarkan Keamanan Arsip</h3>
                    <div class="space-y-2">
                        @foreach($statistikKeamanan as $keamanan)
                            <div class="flex justify-between">
                                <span>{{ $keamanan['nama'] }}</span>
                                <span class="font-bold text-primary-600">{{ $keamanan['jumlah'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Chart.js Script -->
<script>
  const ctx = document.getElementById('arsipChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Arsip Aktif', 'Arsip Inaktif', 'Arsip Musnah'],
      datasets: [{
        label: 'Jumlah Arsip',
        data: [{{ $aktif ?? 0 }}, {{ $inaktif ?? 0 }}, {{ $musnah ?? 0 }}],
        backgroundColor: ['#3d6992', '#3d6992', '#3d6992'],
        borderRadius: 6,
        barThickness: 25,
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: function(context) {
              const label = context.label || '';
              const value = context.raw || 0;
              return `${label}: ${value} arsip`;
            }
          }
        }
      },
      scales: {
        x: {
          beginAtZero: true,
          ticks: { color: '#223b55', font: { size: 14 } },
          grid: { color: '#e5e7eb' }
        },
        y: {
          ticks: { color: '#223b55', font: { size: 14 }, padding: 10 },
          grid: { color: '#f1f5f9' }
        }
      }
    }
  });

  const ctxGabungan = document.getElementById('arsipGabunganChart').getContext('2d');

  const chart = new Chart(ctxGabungan, {
  type: 'bar',
  data: {
    labels: [
      @foreach($statistikFungsi as $fungsi)'{{ $fungsi['nama'] }}',@endforeach
      @foreach($statistikJenis as $jenis)'{{ $jenis['nama'] }}',@endforeach
      @foreach($statistikRetensi as $retensi)'{{ $retensi['nama'] }}',@endforeach
      @foreach($statistikKeamanan as $keamanan)'{{ $keamanan['nama'] }}',@endforeach
    ],
    datasets: [
      {
        label: 'Fungsi',
        data: [
          @foreach($statistikFungsi as $fungsi){{ $fungsi['jumlah'] }},@endforeach
          @foreach($statistikJenis as $jenis)0,@endforeach
          @foreach($statistikRetensi as $retensi)0,@endforeach
          @foreach($statistikKeamanan as $keamanan)0,@endforeach
        ],
        backgroundColor: '#3d6992'
      },
      {
        label: 'Jenis Arsip',
        data: [
          @foreach($statistikFungsi as $fungsi)0,@endforeach
          @foreach($statistikJenis as $jenis){{ $jenis['jumlah'] }},@endforeach
          @foreach($statistikRetensi as $retensi)0,@endforeach
          @foreach($statistikKeamanan as $keamanan)0,@endforeach
        ],
        backgroundColor: '#5a7fa1'
      },
      {
        label: 'Masa Simpan',
        data: [
          @foreach($statistikFungsi as $fungsi)0,@endforeach
          @foreach($statistikJenis as $jenis)0,@endforeach
          @foreach($statistikRetensi as $retensi){{ $retensi['jumlah'] }},@endforeach
          @foreach($statistikKeamanan as $keamanan)0,@endforeach
        ],
        backgroundColor: '#7895b1'
      },
      {
        label: 'Keamanan',
        data: [
          @foreach($statistikFungsi as $fungsi)0,@endforeach
          @foreach($statistikJenis as $jenis)0,@endforeach
          @foreach($statistikRetensi as $retensi)0,@endforeach
          @foreach($statistikKeamanan as $keamanan){{ $keamanan['jumlah'] }},@endforeach
        ],
        backgroundColor: '#96acc1'
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      tooltip: {
        callbacks: {
          label: function(context) {
            const label = context.dataset.label || '';
            const value = context.raw || 0;
            return `${label}: ${value} arsip`;
          }
        }
      },
      legend: {
        labels: {
          font: { size: 12 },
          color: '#223b55'
        }
      }
    },
    scales: {
      x: {
        ticks: {
          color: '#223b55',
          font: { size: 10 },
          maxRotation: 45,
          minRotation: 45
        },
        grid: {
          display: false
        }
      },
      y: {
        beginAtZero: true,
        ticks: { color: '#223b55', font: { size: 12 } },
        grid: { color: '#f1f5f9' }
      }
    }
  },
  plugins: [{
    id: 'categorySeparators',
    afterDraw: (chart) => {
      const ctx = chart.ctx;
      const xAxis = chart.scales.x;

      ctx.save();
      ctx.strokeStyle = '#d1d9e0';
      ctx.lineWidth = 2;

      // Posisi indeks grup (setelah fungsi, jenis, retensi)
      const separatorIndexes = [{{ count($statistikFungsi) }}, {{ count($statistikFungsi) + count($statistikJenis) }}, {{ count($statistikFungsi) + count($statistikJenis) + count($statistikRetensi) }}];

      separatorIndexes.forEach((index) => {
        const x = xAxis.getPixelForTick(index) - (xAxis.getPixelForTick(1) - xAxis.getPixelForTick(0)) / 2;
        ctx.beginPath();
        ctx.moveTo(x, chart.chartArea.top);
        ctx.lineTo(x, chart.chartArea.bottom);
        ctx.stroke();
      });

      ctx.restore();
    }
  }]
});

</script>
@endsection
