@extends('layouts.index')

@section('title', 'Surat Masuk')

@section('content')
    @php
        $currentUser = Auth::user();
    @endphp
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Surat Masuk</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola Data Surat Masuk</p>
        </div>
        <div class="flex gap-2">
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
            @if ($currentUser->isAdmin() || $currentUser->isOperator())
                <a href="{{ route('surat_masuk.laporan.pdf', request()->only(['search','status_surat','jenis_surat'])) }}" target="_blank"
                    class="inline-flex items-center bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-xl transition duration-300 shadow-md hover:shadow-lg w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-8m0 8l-4-4m4 4l4-4m-8 8h8a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v9a2 2 0 002 2z" />
                    </svg>
                    Laporan
                </a>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <form action="{{ route('surat_masuk.index') }}" method="GET" class="flex flex-col md:flex-row gap-2">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Cari nomor agenda, nomor surat, pengirim, perihal, atau keterangan...">
            </div>
            <div class="flex gap-2">
                <select name="status_surat" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Status</option>
                    <option value="Diajukan" {{ request('status_surat') == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                    <option value="Diverifikasi" {{ request('status_surat') == 'Diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                    <option value="Diproses" {{ request('status_surat') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Ditolak" {{ request('status_surat') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="Disetujui" {{ request('status_surat') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Terkirim" {{ request('status_surat') == 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                    <option value="Baru" {{ request('status_surat') == 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Dibaca" {{ request('status_surat') == 'Dibaca' ? 'selected' : '' }}>Dibaca</option>
                </select>
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

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tgl Surat</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pengirim</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Perihal</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    File</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($suratMasuks as $suratMasuk)
                                <tr class="hover:bg-gray-50 transition duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $suratMasuks->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ optional($suratMasuk->tanggal_surat_pengirim)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $suratMasuk->pengirim }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $suratMasuk->perihal }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $statusClass = [
                                                'Diajukan' => 'bg-gray-100 text-gray-800',
                                                'Diproses' => 'bg-orange-100 text-orange-800',
                                                'Ditolak' => 'bg-red-100 text-red-800',
                                                'Diverifikasi' => 'bg-green-100 text-green-800',
                                                'Disetujui' => 'bg-green-100 text-green-800',
                                                'Terkirim' => 'bg-indigo-100 text-indigo-800',
                                                'Baru' => 'bg-purple-100 text-purple-800',
                                                'Dibaca' => 'bg-blue-100 text-blue-800',
                                                'Selesai' => 'bg-teal-100 text-teal-800',
                                                'Diarsipkan' => 'bg-gray-500 text-white',
                                            ];
                                            $status = $suratMasuk->status_tampilan ?? $suratMasuk->status_surat;
                                        @endphp
                                        <button type="button"
                                            class="px-2 py-1 text-xs font-semibold rounded-full status-detail-btn {{ $statusClass[$status] ?? 'bg-gray-200 text-gray-600' }}"
                                            data-id="{{ $suratMasuk->id }}"
                                            data-nomor-agenda="{{ $suratMasuk->nomor_agenda }}"
                                            data-nomor-pengirim="{{ $suratMasuk->nomor_surat_pengirim }}"
                                            data-tgl-surat="{{ optional($suratMasuk->tanggal_surat_pengirim)->format('d-m-Y') }}"
                                            data-tgl-diterima="{{ optional($suratMasuk->tanggal_terima)->format('d-m-Y') }}"
                                            data-pengirim="{{ $suratMasuk->pengirim }}"
                                            data-perihal="{{ $suratMasuk->perihal }}"
                                            data-sifat="{{ $suratMasuk->sifat_surat }}"
                                            data-jurusan="{{ optional($suratMasuk->jurusan)->nama_jurusan ?? '-' }}"
                                            data-keterangan="{{ $suratMasuk->keterangan }}"
                                            data-file-path="{{ $suratMasuk->file_surat_path ? asset($suratMasuk->file_surat_path) : '' }}"
                                            data-file-name="{{ $suratMasuk->nama_file_surat_asli }}">
                                            {{ $status }}
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-y-2">
                                        @php
                                            $status = $suratMasuk->status_surat;
                                            $isOwner = $currentUser->id === $suratMasuk->user_id;
                                        @endphp

                                        {{-- Aksi untuk Operator dan Admin --}}
                                        @if (($currentUser->isOperator() && $isOwner && in_array($status, ['Diajukan', 'Ditolak'])) || $currentUser->isAdmin())
                                            <div class="flex gap-2">
                                                <a href="{{ route('surat_masuk.edit', $suratMasuk->id) }}" title="Edit"
                                                    class="inline-flex items-center p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>

                                                <form action="{{ route('surat_masuk.destroy', $suratMasuk->id) }}"
                                                    method="POST" class="inline-block delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" title="Hapus"
                                                        class="delete-btn inline-flex items-center p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif

                                        {{-- Aksi untuk Sekretaris --}}
                                        @if ($currentUser->isSekretaris())
                                            @if (in_array($status, ['Diajukan', 'Ditolak']))
                                                <div class="flex gap-2">
                                                    <button type="button" title="Verifikasi"
                                                        class="verifikasi-btn w-8 h-8 bg-green-500 hover:bg-green-600 text-white rounded-lg transition"
                                                        data-id="{{ $suratMasuk->id }}" data-action="verifikasi">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>

                                                    <button type="button" title="Kembalikan"
                                                        class="kembalikan-btn w-8 h-8 bg-red-400 hover:bg-red-500 text-white rounded-lg transition"
                                                        data-id="{{ $suratMasuk->id }}" data-action="kembalikan">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif

                                            @if ($status === 'Diverifikasi')
                                                <div class="mt-2">
                                                    <button type="button" title="Teruskan ke Pimpinan"
                                                        class="teruskan-btn w-8 h-8 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition"
                                                        data-id="{{ $suratMasuk->id }}"
                                                        data-action="teruskan_ke_pimpinan">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif
                                        @endif
                                        {{-- Aksi untuk Pimpinan --}}
                                        @if ($currentUser->isPimpinan() && $status === 'Diproses')
                                            <a href="{{ route('disposisi.create', ['surat_masuk_id' => $suratMasuk->id]) }}"
                                                title="Proses Disposisi"
                                                class="inline-flex items-center mt-2 p-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                                </svg>
                                                <span class="ml-1 text-sm">Proses Disposisi</span>
                                            </a>
                                        @endif
                                         {{-- Aksi untuk Penerima Disposisi --}}
                                        @php
                                            $isPenerimaDisposisi = $suratMasuk->disposisis->contains(function (
                                                $disposisi,
                                            ) use ($currentUser) {
                                                return $disposisi->user_penerima_id === $currentUser->id &&
                                                    $disposisi->status_disposisi === 'Baru';
                                            });
                                        @endphp

                                        @if ($isPenerimaDisposisi)
                                        <a href="{{ route('surat_masuk.print', $suratMasuk->id) }}"
                                            class="inline-flex items-center mt-2 p-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition"
                                            title="Cetak Surat Masuk">
                                             <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                             </svg>
                                             <span class="ml-1 text-sm">Cetak</span>
                                         </a>                                         
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Data tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{ $suratMasuks->links() }}
    </div>

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
            const csrfToken = '{{ csrf_token() }}';
            const pimpinanList = @json($pimpinanUsers ?? []);

            document.querySelectorAll('.verifikasi-btn, .kembalikan-btn, .teruskan-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const suratMasukId = this.dataset.id;
                    const action = this.dataset.action;

                    if (action === 'teruskan_ke_pimpinan') {
                        // Logika untuk TERUSKAN (dengan dropdown pimpinan)
                        let pimpinanOptionsHtml = '<option value="">-- Pilih Pimpinan --</option>';
                        pimpinanList.forEach(pimpinan => {
                            pimpinanOptionsHtml +=
                                `<option value="${pimpinan.id}">${pimpinan.name}</option>`;
                        });

                        Swal.fire({
                            title: 'Teruskan Surat ke Pimpinan',
                            html: `<p class="text-md mb-4">Pilih pimpinan yang akan menerima surat ini.</p>
                                   <select id="pimpinan_tujuan_id" class="swal2-select">${pimpinanOptionsHtml}</select>`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Teruskan',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#3B82F6',
                            reverseButtons: true,
                            preConfirm: () => {
                                const pimpinanId = document.getElementById(
                                    'pimpinan_tujuan_id').value;
                                if (!pimpinanId) {
                                    Swal.showValidationMessage(
                                        'Anda harus memilih pimpinan tujuan.');
                                    return false;
                                }
                                return pimpinanId;
                            }
                        }).then((result) => {
                            if (result.isConfirmed && result.value) {
                                sendRequest({
                                    action: action,
                                    pimpinan_tujuan_id: result.value
                                }, suratMasukId);
                            }
                        });

                    } else if (action === 'kembalikan') {
                        Swal.fire({
                            title: 'Kembalikan Surat',
                            html: `<p class="text-md mb-4">Tuliskan alasan pengembalian surat ini.</p>
                                   <textarea id="alasan_kembali" class="swal2-textarea" placeholder="Contoh: Nomor surat salah, perlu perbaikan..."></textarea>`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Kembalikan',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#EF4444',
                            reverseButtons: true,
                            preConfirm: () => {
                                const alasan = document.getElementById('alasan_kembali')
                                    .value;
                                if (!alasan || alasan.trim() === '') {
                                    Swal.showValidationMessage('Alasan wajib diisi.');
                                    return false;
                                }
                                return alasan;
                            }
                        }).then((result) => {
                            if (result.isConfirmed && result.value) {
                                sendRequest({
                                    action: action,
                                    alasan_kembali: result.value
                                }, suratMasukId);
                            }
                        });

                    } else {
                        Swal.fire({
                            title: 'Verifikasi Surat?',
                            text: "Surat akan diverifikasi dan siap untuk diteruskan.",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: "Ya, Verifikasi",
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#10B981',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                sendRequest({
                                    action: action
                                }, suratMasukId);
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

            // Event listener untuk tombol delete
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: 'Hapus Surat Masuk?',
                        text: "Data surat masuk akan dihapus secara permanen dan tidak dapat dikembalikan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#EF4444',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Helper function untuk mengirim request agar tidak duplikasi kode
            function sendRequest(body, suratMasukId) {
                fetch(`/surat-masuk/${suratMasukId}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(body)
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
                        } else {
                            // Pesan error dari backend (jika ada)
                            Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Fetch Error:', error);
                        // Menampilkan pesan error validasi dari backend jika ada
                        let errorMessage = 'Tidak dapat terhubung ke server.';
                        if (error && error.errors) {
                            errorMessage = Object.values(error.errors).flat().join('<br>');
                        } else if (error && error.message) {
                            errorMessage = error.message;
                        }
                        Swal.fire('Error!', errorMessage, 'error');
                    });
            }

            // Flash message
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

            // Show error message if exists
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
