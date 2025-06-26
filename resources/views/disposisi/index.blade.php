@extends('layouts.index')

@section('title', 'Disposisi')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Disposisi</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola Data Disposisi</p>
        </div>
        {{-- Tombol Tambah Disposisi - Hanya untuk Pimpinan, Kepala Lembaga, Kepala Bidang --}}
        @php
            $currentUser = Auth::user();
        @endphp
        @if($currentUser->isPimpinan() || $currentUser->isKepalaLembaga() || $currentUser->isKepalaBidang() || $currentUser->isAdmin())
            <a href="{{ route('disposisi.create') }}"
                class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-xl transition duration-300 shadow-md hover:shadow-lg w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Disposisi
            </a>
        @endif
    </div>

    <!-- Search Section -->
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

    <!-- Success Message -->
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

    <!-- Table Content -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Surat Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemberi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penerima</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Isi Disposisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl.Disposisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Disposisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent Disposisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($disposisis as $disposisi)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $disposisis->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($disposisi->suratMasuk)
                                    <span class="font-semibold">{{ $disposisi->suratMasuk->nomor_surat_pengirim }}</span><br>
                                    <span class="text-xs text-gray-500">{{ $disposisi->suratMasuk->perihal }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $disposisi->userPemberi ? $disposisi->userPemberi->name : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @php
                                    $penerima = [];
                                    if ($disposisi->userPenerima) $penerima[] = $disposisi->userPenerima->name;
                                    if ($disposisi->divisiPenerima) $penerima[] = $disposisi->divisiPenerima->nama_divisi;
                                    if ($disposisi->jurusanPenerima) $penerima[] = $disposisi->jurusanPenerima->nama_jurusan;
                                @endphp
                                {{ $penerima ? implode(', ', $penerima) : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs overflow-hidden text-ellipsis">
                                <span class="block font-medium">{{ Str::limit($disposisi->isi_disposisi, 40) }}</span>
                                {{-- @if($disposisi->instruksi_kepada || $disposisi->petunjuk_disposisi)
                                    <span class="text-xs text-gray-500 block">
                                        ({{ implode(', ', array_filter([implode(', ', $disposisi->getInstruksiKepadaArray()), implode(', ', $disposisi->getPetunjukDisposisiArray())])) }})
                                    </span>
                                @endif --}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $disposisi->tanggal_disposisi ? \Carbon\Carbon::parse($disposisi->tanggal_disposisi)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @php
                                    $statusClass = [
                                        'Baru' => 'bg-blue-100 text-blue-800',
                                        'Diterima' => 'bg-yellow-100 text-yellow-800',
                                        'Dikerjakan' => 'bg-green-100 text-green-800',
                                        'Selesai' => 'bg-teal-100 text-teal-800',
                                        'Ditolak' => 'bg-red-100 text-red-800',
                                        'Diteruskan' => 'bg-purple-100 text-purple-800',
                                    ];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass[$disposisi->status_disposisi] ?? 'bg-gray-200 text-gray-600' }}">
                                    {{ $disposisi->status_disposisi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $disposisi->parentDisposisi ? Str::limit($disposisi->parentDisposisi->isi_disposisi, 20) : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                {{-- Aksi untuk Edit dan Hapus --}}
                                <a href="{{ route('disposisi.edit', $disposisi->id) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('disposisi.destroy', $disposisi->id) }}" method="POST"
                                    class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition duration-200 delete-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>

                                {{-- Aksi Tambahan untuk Disposisi --}}
                                @php
                                    $currentUser = Auth::user();
                                @endphp
                                @if($disposisi->user_penerima_id === $currentUser->id || ($disposisi->divisi_penerima_id && $currentUser->divisi_id === $disposisi->divisi_penerima_id) || ($disposisi->jurusan_penerima_id && $currentUser->jurusan_id === $disposisi->jurusan_penerima_id))
                                    {{-- Tombol untuk mengubah status disposisi --}}
                                    @if($disposisi->status_disposisi === 'Baru')
                                        <button type="button" title="Terima Disposisi"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200 update-disposisi-status-btn"
                                            data-disposisi-id="{{ $disposisi->id }}" data-action="Diterima">
                                            Terima
                                        </button>
                                    @elseif($disposisi->status_disposisi === 'Diterima' || $disposisi->status_disposisi === 'Dikerjakan')
                                        <button type="button" title="Selesaikan Disposisi"
                                            class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 update-disposisi-status-btn"
                                            data-disposisi-id="{{ $disposisi->id }}" data-action="Selesai">
                                            Selesai
                                        </button>
                                        <button type="button" title="Diteruskan Disposisi"
                                            class="inline-flex items-center px-3 py-1.5 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition duration-200 update-disposisi-status-btn"
                                            data-disposisi-id="{{ $disposisi->id }}" data-action="Diteruskan">
                                            Teruskan
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $disposisis->links() }}
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-500">
            Padang, &copy; {{ date('Y') }} Politeknik Negeri Padang
        </p>
    </div>
@endsection

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete button click
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');

                Swal.fire({
                    title: 'Hapus disposisi?',
                    text: "Data yang dihapus tidak dapat dikembalikan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'swal2-compact',
                        title: 'text-base font-medium',
                        htmlContainer: 'text-sm',
                        confirmButton: 'text-sm px-3 py-2',
                        cancelButton: 'text-sm px-3 py-2'
                    },
                    width: 'auto',
                    padding: '1rem'
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
                const action = this.dataset.action; // 'Diterima', 'Selesai', 'Diteruskan'
                let title = '';
                let text = '';
                let icon = '';

                if (action === 'Diterima') {
                    title = 'Terima Disposisi?';
                    text = 'Disposisi akan ditandai sebagai diterima.';
                    icon = 'question';
                } else if (action === 'Selesai') {
                    title = 'Selesaikan Disposisi?';
                    text = 'Disposisi akan ditandai sebagai selesai ditindaklanjuti.';
                    icon = 'question';
                } else if (action === 'Diteruskan') {
                    title = 'Teruskan Disposisi?';
                    text = 'Disposisi akan diteruskan ke penerima lain.';
                    icon = 'question';
                    // Tambahan: Logika untuk memilih penerima lain (mirip dengan 'teruskan_ke_pimpinan' di surat masuk)
                    // Ini memerlukan input SweetAlert2 jenis 'select' dan fetch daftar user/divisi/jurusan
                    // Untuk saat ini, kita hanya fokus pada perubahan status.
                }

                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonText: action,
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'swal2-compact',
                        title: 'text-base font-medium',
                        htmlContainer: 'text-sm',
                        confirmButton: 'text-sm px-3 py-2',
                        cancelButton: 'text-sm px-3 py-2'
                    },
                    width: 'auto',
                    padding: '1rem'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('_method', 'PUT'); // Menggunakan PUT
                        formData.append('status', action); // Kirim status baru

                        fetch(`{{ route('disposisi.updateStatus', ['disposisi' => ':id']) }}`.replace(':id', disposisiId), {
                            method: 'POST', // Method POST karena _method=PUT
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(errorData => {
                                    throw new Error(errorData.message || errorData.errors ? Object.values(errorData.errors).flat().join('\n') : 'Terjadi kesalahan pada server.');
                                });
                            }
                            return response.json();
                        })
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
                            Swal.fire('Error!', error.message || 'Terjadi kesalahan pada server.', 'error');
                        });
                    }
                });
            });
        });


        // Show success message if exists
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal2-compact',
                    title: 'text-base font-medium'
                },
                width: 'auto',
                padding: '1rem'
            });
        @endif

        // Show error message if exists (jika ada error dari controller)
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                timer: 2000,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal2-compact',
                    title: 'text-base font-medium'
                },
                width: 'auto',
                padding: '1rem'
            });
        @endif
    });
</script>
@endpush
