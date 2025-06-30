@extends('layouts.index')

@section('title', 'Disposisi')

@section('content')
    @php
        $currentUser = Auth::user();
    @endphp
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Disposisi</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola Data Disposisi</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <form action="{{ route('disposisi.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Cari isi disposisi, catatan, surat masuk, atau penerima...">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <a href="{{ route('disposisi.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </a>
            </div>
        </form>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
            <p class="font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    {{-- HEADER DIUBAH SESUAI PERMINTAAN --}}
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disposisi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penerima
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perintah
                            Disposisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($disposisis as $disposisi)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $disposisis->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                @if ($disposisi->suratMasuk)
                                    <p class="font-semibold text-gray-800">
                                        {{ $disposisi->suratMasuk->nomor_surat_pengirim }}</p>
                                    <p class="text-xs text-gray-600">
                                        <span class="font-medium">Dari:</span> {{ $disposisi->suratMasuk->pengirim }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        <span class="font-medium">Perihal:</span>
                                        {{ Str::limit($disposisi->suratMasuk->perihal, 40) }}
                                    </p>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if ($disposisi->userPenerima)
                                    {{ $disposisi->userPenerima->name }} <br>
                                    @if ($disposisi->userPenerima->divisi)
                                        <span class="text-sm text-gray-500">
                                            {{ $disposisi->userPenerima->divisi->nama_divisi }}
                                        </span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $disposisi->tanggal_disposisi ? \Carbon\Carbon::parse($disposisi->tanggal_disposisi)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                {!! !empty($disposisi->petunjuk_disposisi) ? implode('<br>', $disposisi->petunjuk_disposisi) : '-' !!}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @php
                                    $statusClass = [
                                        'Baru' => 'bg-purple-100 text-purple-800',
                                        'Diterima' => 'bg-blue-100 text-blue-800',
                                        'Dikerjakan' => 'bg-green-100 text-green-800',
                                        'Selesai' => 'bg-teal-100 text-teal-800',
                                        'Ditolak' => 'bg-red-100 text-red-800',
                                        'Diteruskan' => 'bg-purple-100 text-purple-800',
                                    ];
                                @endphp
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass[$disposisi->status_disposisi] ?? 'bg-gray-200 text-gray-600' }}">
                                    {{ $disposisi->status_disposisi }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    {{-- Aksi Edit dan Hapus hanya bisa dilakukan oleh pembuat disposisi atau Admin --}}
                                    @if ($currentUser->id === $disposisi->user_pemberi_id || $currentUser->isAdmin())
                                        <a href="{{ route('disposisi.edit', $disposisi->id) }}" title="Edit"
                                            class="inline-flex items-center p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('disposisi.destroy', $disposisi->id) }}" method="POST"
                                            class="inline-block delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" title="Hapus"
                                                class="delete-btn inline-flex items-center p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                Data disposisi tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $disposisis->links() }}
    </div>

    <div class="mt-8 text-center">
        <p class="text-sm text-gray-500">
            Padang, &copy; {{ date('Y') }} Politeknik Negeri Padang
        </p>
    </div>
@endsection

@push('scripts')
    {{-- SCRIPT TIDAK PERLU DIUBAH, KARENA HANYA MENGUBAH TAMPILAN TABEL --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete button click
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');
                    Swal.fire({
                        title: 'Hapus disposisi?',
                        text: "Data yang dihapus tidak dapat dikembalikan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Handle update disposisi status buttons
            document.querySelectorAll('.update-disposisi-status-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const disposisiId = this.dataset.disposisiId;
                    const action = this.dataset.action;
                    let config = {
                        title: 'Anda yakin?',
                        icon: 'question',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        confirmButtonText: `Ya, ${action}`
                    };

                    if (action === 'Diterima') {
                        config.text = 'Disposisi akan ditandai sebagai diterima.';
                    } else if (action === 'Selesai') {
                        config.text = 'Disposisi akan ditandai sebagai selesai ditindaklanjuti.';
                    }

                    Swal.fire(config).then((result) => {
                        if (result.isConfirmed) {
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'PUT');
                            formData.append('status', action);

                            fetch(`{{ url('disposisi') }}/${disposisiId}/update-status`, {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Berhasil!', data.message, 'success')
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire('Gagal!', data.message, 'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Error!',
                                        'Terjadi kesalahan pada server.', 'error');
                                });
                        }
                    });
                });
            });
        });
    </script>
@endpush
