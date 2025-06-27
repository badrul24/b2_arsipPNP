@extends('layouts.index')

@section('title', 'Surat Masuk')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Surat Masuk</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola Data Surat Masuk</p>
        </div>
        {{-- Tombol Tambah Surat Masuk (hanya untuk Admin atau Operator) --}}
        @php
            $currentUser = Auth::user();
        @endphp
        @if ($currentUser->isAdmin() || $currentUser->isOperator())
            <a href="{{ route('surat_masuk.create') }}"
                class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-xl transition duration-300 shadow-md hover:shadow-lg w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Surat Masuk
            </a>
        @endif
    </div>

    <!-- Search Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <form action="{{ route('surat_masuk.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Cari nomor agenda, nomor surat, pengirim, perihal, atau keterangan...">
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
                <a href="{{ route('surat_masuk.index') }}"
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl.Surat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($suratMasuks as $suratMasuk)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $suratMasuks->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $suratMasuk->tanggal_surat_pengirim ? \Carbon\Carbon::parse($suratMasuk->tanggal_surat_pengirim)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $suratMasuk->pengirim }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $suratMasuk->perihal }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @php
                                    $statusClass = [
                                        'Diajukan' => 'bg-blue-100 text-blue-800',
                                        'Diproses' => 'bg-orange-100 text-orange-800',
                                        'Ditolak' => 'bg-red-100 text-red-800',
                                        'Diverifikasi' => 'bg-green-100 text-green-800',
                                        'Terkirim' => 'bg-indigo-100 text-indigo-800',
                                        'Baru' => 'bg-purple-100 text-purple-800',
                                        'Dibaca' => 'bg-gray-100 text-gray-800',
                                        'Selesai' => 'bg-teal-100 text-teal-800',
                                        'Diarsipkan' => 'bg-gray-500 text-white',
                                    ];
                                @endphp
                                {{-- Status sebagai button yang dapat diklik untuk detail --}}
                                <button type="button"
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full status-detail-btn {{ $statusClass[$suratMasuk->status_surat] ?? 'bg-gray-200 text-gray-600' }}"
                                    data-id="{{ $suratMasuk->id }}" data-nomor-agenda="{{ $suratMasuk->nomor_agenda }}"
                                    data-nomor-pengirim="{{ $suratMasuk->nomor_surat_pengirim }}"
                                    data-tgl-surat="{{ $suratMasuk->tanggal_surat_pengirim ? \Carbon\Carbon::parse($suratMasuk->tanggal_surat_pengirim)->format('d-m-Y') : '-' }}"
                                    data-tgl-diterima="{{ $suratMasuk->tanggal_terima ? \Carbon\Carbon::parse($suratMasuk->tanggal_terima)->format('d-m-Y') : '-' }}"
                                    data-pengirim="{{ $suratMasuk->pengirim }}" data-perihal="{{ $suratMasuk->perihal }}"
                                    data-sifat="{{ $suratMasuk->sifat_surat }}"
                                    data-jurusan="{{ $suratMasuk->jurusan ? $suratMasuk->jurusan->nama_jurusan : '-' }}"
                                    data-keterangan="{{ $suratMasuk->keterangan }}"
                                    data-file-path="{{ $suratMasuk->file_surat_path ? asset($suratMasuk->file_surat_path) : '' }}"
                                    data-file-name="{{ $suratMasuk->nama_file_surat_asli }}">
                                    {{ $suratMasuk->status_surat }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if ($suratMasuk->file_surat_path)
                                    <a href="{{ route('surat_masuk.download', $suratMasuk->id) }}" target="_blank"
                                        class="text-primary-600 hover:text-primary-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                @php
                                    $currentUser = Auth::user();
                                @endphp

                                {{-- Aksi Edit dan Hapus (untuk Pengagenda/Admin) --}}
                                @if (
                                    ($currentUser->isOperator() &&
                                        $currentUser->id === $suratMasuk->user_id &&
                                        in_array($suratMasuk->status_surat, ['Diajukan', 'Ditolak'])) ||
                                        $currentUser->isAdmin())
                                    <a href="{{ route('surat_masuk.edit', $suratMasuk->id) }}" title="Edit"
                                        class="inline-flex items-center p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('surat_masuk.destroy', $suratMasuk->id) }}" method="POST"
                                        class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" title="Hapus"
                                            class="inline-flex items-center p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition duration-200 delete-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                @endif

                                {{-- Aksi untuk Sekretaris: Verifikasi, Kembalikan, Teruskan --}}
                                @if ($currentUser->isSekretaris())
                                    @if (in_array($suratMasuk->status_surat, ['Diajukan', 'Ditolak']))
                                        {{-- Hanya jika 'Diajukan' atau 'Ditolak' --}}
                                        <div class="flex flex-row gap-2">
                                            <button type="button" title="Verifikasi"
                                                class="inline-flex items-center justify-center p-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition duration-200 verifikasi-btn w-8 h-8"
                                                data-id="{{ $suratMasuk->id }}" data-action="verifikasi">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                            <button type="button" title="Kembalikan"
                                                class="inline-flex items-center justify-center p-2 bg-red-400 hover:bg-red-500 text-white rounded-lg transition duration-200 kembalikan-btn w-8 h-8"
                                                data-id="{{ $suratMasuk->id }}" data-action="kembalikan">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                    {{-- Tombol Teruskan hanya muncul jika sudah Diverifikasi --}}
                                    @if ($suratMasuk->status_surat === 'Diverifikasi')
                                        <div class="flex flex-row gap-2 mt-2">
                                            <button type="button" title="Teruskan"
                                                class="inline-flex items-center justify-center p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200 teruskan-btn w-8 h-8"
                                                data-id="{{ $suratMasuk->id }}" data-action="teruskan_ke_pimpinan">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                @endif

                                {{-- Aksi untuk Pimpinan: Lanjut Disposisi --}}
                                @if ($currentUser->isPimpinan() && $suratMasuk->status_surat === 'Diproses')
                                    {{-- Jika statusnya 'Diproses', artinya menunggu Pimpinan untuk disposisi --}}
                                    <a href="{{ route('disposisi.create', ['surat_masuk_id' => $suratMasuk->id]) }}"
                                        title="Proses Disposisi"
                                        class="inline-flex items-center p-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                        Proses Disposisi
                                    </a>
                                @endif

                                {{-- Aksi untuk Penerima Disposisi: Lihat Disposisi/Selesaikan --}}
                                @if ($currentUser->id && $suratMasuk->status_surat === 'Didisposisi')
                                    @php
                                        // Cek apakah ada disposisi yang ditujukan ke user ini
                                        $disposisiTujuan = \App\Models\Disposisi::where(
                                            'surat_masuk_id',
                                            $suratMasuk->id,
                                        )
                                            ->where(function ($q_disp) use ($currentUser) {
                                                $q_disp->where('user_penerima_id', $currentUser->id);
                                                if ($currentUser->divisi_id) {
                                                    $q_disp->orWhere('divisi_penerima_id', $currentUser->divisi_id);
                                                }
                                                if ($currentUser->jurusan_id) {
                                                    $q_disp->orWhere('jurusan_penerima_id', $currentUser->jurusan_id);
                                                }
                                            })
                                            ->first();
                                    @endphp
                                    @if ($disposisiTujuan)
                                        <a href="{{ route('disposisi.show', $disposisiTujuan->id) }}"
                                            title="Lihat Disposisi"
                                            class="inline-flex items-center p-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat Disposisi
                                        </a>
                                        {{-- Tombol untuk mengubah status disposisi menjadi Selesai --}}
                                        @if ($disposisiTujuan->status_disposisi !== 'Selesai')
                                            <button type="button" title="Selesaikan Disposisi"
                                                class="inline-flex items-center p-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 selesaikan-disposisi-btn"
                                                data-disposisi-id="{{ $disposisiTujuan->id }}"
                                                data-surat-masuk-id="{{ $suratMasuk->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Selesai
                                            </button>
                                        @endif
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
        {{ $suratMasuks->links() }}
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
                        title: 'Hapus surat masuk?',
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

            // Handle Sekretaris action buttons (Verifikasi, Kembalikan, Teruskan)
            document.querySelectorAll('.verifikasi-btn, .kembalikan-btn, .teruskan-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const suratMasukId = this.dataset.id;
                    const action = this.dataset.action;
                    let title = '';
                    let text = '';
                    let icon = '';
                    let input = null;
                    let inputPlaceholder = '';
                    let inputOptions = {};

                    if (action === 'verifikasi') {
                        title = 'Verifikasi Surat Masuk?';
                        text = 'Surat akan diverifikasi dan siap diteruskan.';
                        icon = 'question';
                        showSwalPrompt();
                    } else if (action === 'kembalikan') {
                        title = 'Kembalikan Surat Masuk?';
                        text =
                            'Surat akan dikembalikan ke pengagenda untuk revisi. Mohon berikan alasan.';
                        icon = 'warning';
                        input = 'textarea';
                        inputPlaceholder = 'Alasan pengembalian...';
                        showSwalPrompt();
                    } else if (action === 'teruskan_ke_pimpinan') {
                        title = 'Teruskan Surat Masuk ke Pimpinan?';
                        text =
                            'Surat akan diteruskan ke Pimpinan untuk disposisi. Pilih pimpinan tujuan:';
                        icon = 'question';
                        input = 'select';

                        // Menggunakan data pimpinan yang sudah diteruskan dari controller
                        const pimpinanData = @json($pimpinanUsers);

                        if (pimpinanData && pimpinanData.length > 0) {
                            pimpinanData.forEach(pimpinan => {
                                inputOptions[pimpinan.id] = pimpinan.name;
                            });
                        } else {
                            Swal.fire('Informasi', 'Tidak ada pimpinan ditemukan untuk diteruskan.',
                                'info');
                            return;
                        }
                        showSwalPrompt();
                    }

                    function showSwalPrompt() {
                        Swal.fire({
                            title: title,
                            text: text,
                            icon: icon,
                            showCancelButton: true,
                            confirmButtonText: (action === 'kembalikan' ? 'Kembalikan' : (
                                action === 'verifikasi' ? 'Verifikasi' : 'Teruskan'
                            )),
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            input: input,
                            inputPlaceholder: inputPlaceholder,
                            inputOptions: inputOptions,
                            inputValidator: (value) => {
                                if (action === 'kembalikan' && !value) {
                                    return 'Alasan pengembalian tidak boleh kosong!';
                                }
                                if (action === 'teruskan_ke_pimpinan' && !value) {
                                    return 'Pimpinan tujuan wajib dipilih!';
                                }
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const formData = new FormData();
                                formData.append('_token', '{{ csrf_token() }}');
                                formData.append('_method', 'POST');
                                formData.append('action', action);
                                if (action === 'kembalikan') {
                                    formData.append('alasan_kembali', result.value);
                                } else if (action === 'teruskan_ke_pimpinan') {
                                    formData.append('pimpinan_tujuan_id', result.value);
                                }

                                fetch(`{{ route('surat_masuk.proses', ['surat_masuk' => ':id']) }}`
                                        .replace(':id', suratMasukId), {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'Accept': 'application/json'
                                            }
                                        })
                                    .then(response => {
                                        if (!response.ok) {
                                            return response.json().then(errorData => {
                                                let errorMessage =
                                                    'Terjadi kesalahan pada server.';
                                                if (errorData) {
                                                    // Check for the custom error format from the try-catch block
                                                    if (errorData.error) {
                                                        errorMessage =
                                                            `${errorData.message}\\n\\n[Debug Info]: ${errorData.error}`;
                                                    }
                                                    // Check for a standard message property
                                                    else if (errorData
                                                        .message) {
                                                        errorMessage = errorData
                                                            .message;
                                                    }
                                                    // Check for Laravel's validation error format
                                                    else if (errorData.errors) {
                                                        errorMessage = Object
                                                            .values(errorData
                                                                .errors).flat()
                                                            .join('\\n');
                                                    }
                                                }
                                                throw new Error(errorMessage);
                                            });
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire('Berhasil!', data.message,
                                                    'success')
                                                .then(() => location.reload());
                                        } else {
                                            Swal.fire('Gagal!', data.message, 'error');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        Swal.fire('Error!', error.message ||
                                            'Terjadi kesalahan pada server.',
                                            'error');
                                    });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol status yang bisa diklik
            document.querySelectorAll('.status-detail-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const nomorAgenda = this.dataset.nomorAgenda;
                    const nomorPengirim = this.dataset.nomorPengirim;
                    const tglSurat = this.dataset.tglSurat;
                    const tglDiterima = this.dataset.tglDiterima;
                    const pengirim = this.dataset.pengirim;
                    const perihal = this.dataset.perihal;
                    const status = this.textContent.trim();
                    const sifat = this.dataset.sifat;
                    const jurusan = this.dataset.jurusan;
                    const keterangan = this.dataset.keterangan || 'Tidak ada keterangan.';
                    const filePath = this.dataset.filePath;
                    const fileName = this.dataset.fileName;

                    let fileHtml = '';
                    if (filePath) {
                        fileHtml =
                            `<p><strong>File:</strong> <a href="${filePath}" target="_blank" class="text-blue-600 hover:underline">${fileName}</a></p>`;
                    } else {
                        fileHtml = `<p><strong>File:</strong> Tidak ada file terlampir.</p>`;
                    }

                    Swal.fire({
                        title: `Detail Surat Masuk <br><strong>No. Agenda: ${nomorAgenda}</strong>`,
                        html: `
                        <div class="text-left space-y-1 text-sm">
                            <p><strong>Nomor Pengirim:</strong> ${nomorPengirim}</p>
                            <p><strong>Tanggal Surat:</strong> ${tglSurat}</p>
                            <p><strong>Tanggal Diterima:</strong> ${tglDiterima}</p>
                            <p><strong>Pengirim:</strong> ${pengirim}</p>
                            <p><strong>Perihal:</strong> ${perihal}</p>
                            <p><strong>Sifat:</strong> ${sifat}</p>
                            <p><strong>Jurusan:</strong> ${jurusan}</p>
                            <p><strong>Status:</strong> ${status}</p>
                            ${fileHtml}
                            <p class="mt-2"><strong>Keterangan:</strong><br>${keterangan}</p>
                        </div>
                    `,
                        icon: 'info',
                        showConfirmButton: true,
                        confirmButtonText: 'Tutup',
                        customClass: {
                            popup: 'swal2-compact',
                            title: 'text-base font-medium',
                            htmlContainer: 'text-sm',
                            confirmButton: 'text-sm px-3 py-2',
                        },
                        width: '600px',
                        padding: '1rem'
                    });
                });
            });

            // Handle Selesaikan Disposisi button click
            document.querySelectorAll('.selesaikan-disposisi-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const disposisiId = this.dataset.disposisiId;
                    const suratMasukId = this.dataset.suratMasukId;

                    Swal.fire({
                        title: 'Selesaikan Disposisi?',
                        text: "Aksi ini akan menandai disposisi dan surat terkait sebagai selesai ditindaklanjuti.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10B981', // Green
                        cancelButtonColor: '#6B7280', // Gray
                        confirmButtonText: 'Selesaikan',
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
                            formData.append('_method', 'PUT');
                            formData.append('action', 'selesaikan_disposisi');
                            formData.append('surat_masuk_id',
                                suratMasukId); // Kirim surat_masuk_id juga

                            fetch(`{{ route('disposisi.updateStatus', ['disposisi' => ':id']) }}`
                                    .replace(':id', disposisiId), {
                                        method: 'POST', // Menggunakan POST karena _method='PUT' di formData
                                        body: formData,
                                        headers: {
                                            'Accept': 'application/json'
                                        }
                                    })
                                .then(response => {
                                    if (!response.ok) {
                                        return response.json().then(errorData => {
                                            let errorMessage =
                                                'Terjadi kesalahan pada server.';
                                            if (errorData) {
                                                // Check for the custom error format from the try-catch block
                                                if (errorData.error) {
                                                    errorMessage =
                                                        `${errorData.message}\\n\\n[Debug Info]: ${errorData.error}`;
                                                }
                                                // Check for a standard message property
                                                else if (errorData.message) {
                                                    errorMessage = errorData
                                                        .message;
                                                }
                                                // Check for Laravel's validation error format
                                                else if (errorData.errors) {
                                                    errorMessage = Object
                                                        .values(errorData
                                                            .errors).flat()
                                                        .join('\\n');
                                                }
                                            }
                                            throw new Error(errorMessage);
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
                                    Swal.fire('Error!', error.message ||
                                        'Terjadi kesalahan pada server.', 'error');
                                });
                        }
                    });
                });
            });

            // Show success message if exists
            @if (session('success'))
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
            @if (session('error'))
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
