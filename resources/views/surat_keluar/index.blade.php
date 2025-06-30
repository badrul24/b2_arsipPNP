@extends('layouts.index')

@section('title', 'Surat Keluar')

@section('content')
    @php
        $currentUser = Auth::user();
    @endphp
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Surat Keluar</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola Data Surat Keluar</p>
        </div>
        @if ($currentUser->isAdmin() || $currentUser->isSekretaris() || $currentUser->isPimpinan() || $currentUser->isKepalaLembaga() || $currentUser->isKepalaBidang() || $currentUser->isOperator())
            <a href="{{ route('surat_keluar.create') }}"
                class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-xl transition duration-300 shadow-md hover:shadow-lg w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Surat Keluar
            </a>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <form action="{{ route('surat_keluar.index') }}" method="GET" class="flex flex-col md:flex-row gap-2">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Cari nomor agenda, nomor surat, atau lainnya...">
            </div>
            <div class="flex gap-2">
                <select name="status_surat" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Status</option>
                    <option value="Draft" {{ request('status_surat') == 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Terkirim" {{ request('status_surat') == 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                    <option value="Diterima" {{ request('status_surat') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Dibaca" {{ request('status_surat') == 'Dibaca' ? 'selected' : '' }}>Dibaca</option>
                    <option value="Selesai" {{ request('status_surat') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Diarsipkan" {{ request('status_surat') == 'Diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
                </select>
                <select name="jenis_surat" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Jenis</option>
                    <option value="Surat Undangan" {{ request('jenis_surat') == 'Surat Undangan' ? 'selected' : '' }}>Surat Undangan</option>
                    <option value="Surat Pemberitahuan" {{ request('jenis_surat') == 'Surat Pemberitahuan' ? 'selected' : '' }}>Surat Pemberitahuan</option>
                    <option value="Surat Permohonan" {{ request('jenis_surat') == 'Surat Permohonan' ? 'selected' : '' }}>Surat Permohonan</option>
                    <option value="Surat Keputusan" {{ request('jenis_surat') == 'Surat Keputusan' ? 'selected' : '' }}>Surat Keputusan</option>
                    <option value="Surat Edaran" {{ request('jenis_surat') == 'Surat Edaran' ? 'selected' : '' }}>Surat Edaran</option>
                    <option value="Surat Tugas" {{ request('jenis_surat') == 'Surat Tugas' ? 'selected' : '' }}>Surat Tugas</option>
                    <option value="Surat Pengantar" {{ request('jenis_surat') == 'Surat Pengantar' ? 'selected' : '' }}>Surat Pengantar</option>
                    <option value="Surat Keterangan" {{ request('jenis_surat') == 'Surat Keterangan' ? 'selected' : '' }}>Surat Keterangan</option>
                    <option value="Surat Lainnya" {{ request('jenis_surat') == 'Surat Lainnya' ? 'selected' : '' }}>Surat Lainnya</option>
                </select>
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <a href="{{ route('surat_keluar.index') }}"
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
                                    Perihal</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis</th>
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
                            @forelse ($suratKeluars as $suratKeluar)
                                <tr class="hover:bg-gray-50 transition duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $suratKeluars->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ optional($suratKeluar->tanggal_surat)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $suratKeluar->perihal }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $suratKeluar->jenis_surat }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $statusClass = [
                                                'Draft' => 'bg-gray-100 text-gray-800',
                                                'Terkirim' => 'bg-blue-100 text-blue-800',
                                                'Diterima' => 'bg-green-100 text-green-800',
                                                'Dibaca' => 'bg-indigo-100 text-indigo-800',
                                                'Selesai' => 'bg-teal-100 text-teal-800',
                                                'Diarsipkan' => 'bg-gray-500 text-white',
                                            ];
                                        @endphp
                                        <button type="button"
                                            class="px-2 py-1 text-xs font-semibold rounded-full status-detail-btn {{ $statusClass[$suratKeluar->status_surat] ?? 'bg-gray-200 text-gray-600' }}"
                                            data-id="{{ $suratKeluar->id }}"
                                            data-nomor-agenda="{{ $suratKeluar->nomor_agenda }}"
                                            data-nomor-surat="{{ $suratKeluar->nomor_surat_keluar }}"
                                            data-tgl-surat="{{ optional($suratKeluar->tanggal_surat)->format('d-m-Y') }}"
                                            data-tujuan="{{ $suratKeluar->tujuan_surat }}"
                                            data-perihal="{{ $suratKeluar->perihal }}"
                                            data-pengirim="{{ $suratKeluar->pengirim }}"
                                            data-penerima="{{ $suratKeluar->penerima }}"
                                            data-jenis="{{ $suratKeluar->jenis_surat }}"
                                            data-sifat="{{ $suratKeluar->sifat_surat }}"
                                            data-jurusan="{{ optional($suratKeluar->jurusan)->nama_jurusan ?? '-' }}"
                                            data-divisi="{{ optional($suratKeluar->divisi)->nama_divisi ?? '-' }}"
                                            data-isi="{{ $suratKeluar->isi_surat ?? 'Tidak ada isi surat.' }}"
                                            data-keterangan="{{ $suratKeluar->keterangan ?? 'Tidak ada keterangan.' }}"
                                            data-file-path="{{ $suratKeluar->file_surat_path ? asset($suratKeluar->file_surat_path) : '' }}"
                                            data-file-name="{{ $suratKeluar->nama_file_surat_asli }}">
                                            {{ $suratKeluar->status_surat }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($suratKeluar->file_surat_path)
                                            <a href="{{ route('surat_keluar.download', $suratKeluar->id) }}" target="_blank"
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
                                            $status = $suratKeluar->status_surat;
                                            $isOwner = $currentUser->id === $suratKeluar->user_id;
                                            $isPenerima = $currentUser->name === $suratKeluar->penerima;
                                            $canEdit = ($currentUser->isAdmin() || $currentUser->isSekretaris() || 
                                                      ($currentUser->isPimpinan() && $currentUser->divisi_id == $suratKeluar->divisi_id) ||
                                                      ($currentUser->isOperator() && $isOwner));
                                        @endphp

                                        {{-- Aksi untuk Penerima Surat (Hanya Cetak) --}}
                                        @if ($isPenerima && in_array($status, ['Terkirim', 'Diterima']))
                                            <div class="flex gap-2">
                                                <a href="{{ route('surat_keluar.print', $suratKeluar->id) }}" 
                                                   title="Cetak Surat Keluar"
                                                   class="inline-flex items-center p-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                    </svg>
                                                    Cetak
                                                </a>
                                            </div>
                                        @else
                                            {{-- Aksi untuk Edit dan Delete (Bukan Penerima) --}}
                                            @if (($canEdit && $status === 'Draft') || $currentUser->isAdmin())
                                                <div class="flex gap-2">
                                                    <a href="{{ route('surat_keluar.edit', $suratKeluar->id) }}" title="Edit"
                                                        class="inline-flex items-center p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('surat_keluar.destroy', $suratKeluar->id) }}"
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
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
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
        {{ $suratKeluars->links() }}
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

            // Event listener untuk tombol status yang bisa diklik
            document.querySelectorAll('.status-detail-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const nomorAgenda = this.dataset.nomorAgenda;
                    const nomorSurat = this.dataset.nomorSurat;
                    const tglSurat = this.dataset.tglSurat;
                    const tujuan = this.dataset.tujuan;
                    const perihal = this.dataset.perihal;
                    const pengirim = this.dataset.pengirim;
                    const penerima = this.dataset.penerima;
                    const jenis = this.dataset.jenis;
                    const sifat = this.dataset.sifat;
                    const jurusan = this.dataset.jurusan;
                    const divisi = this.dataset.divisi;
                    const isi = this.dataset.isi;
                    const keterangan = this.dataset.keterangan;
                    const filePath = this.dataset.filePath;
                    const fileName = this.dataset.fileName;

                    let fileHtml = '';
                    if (filePath) {
                        fileHtml =
                            `<p><strong>File:</strong> <a href="${filePath}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">${fileName}</a></p>`;
                    } else {
                        fileHtml = `<p><strong>File:</strong> Tidak ada file terlampir.</p>`;
                    }

                    Swal.fire({
                        title: `Detail Surat Keluar <br><strong>No. Agenda: ${nomorAgenda}</strong>`,
                        html: `
                        <div class="text-left space-y-1 text-sm">
                            <p><strong>Nomor Surat:</strong> ${nomorSurat}</p>
                            <p><strong>Tanggal Surat:</strong> ${tglSurat}</p>
                            <p><strong>Tujuan:</strong> ${tujuan}</p>
                            <p><strong>Perihal:</strong> ${perihal}</p>
                            <p><strong>Pengirim:</strong> ${pengirim}</p>
                            <p><strong>Penerima:</strong> ${penerima}</p>
                            <p><strong>Jenis:</strong> ${jenis}</p>
                            <p><strong>Sifat:</strong> ${sifat}</p>
                            <p><strong>Jurusan:</strong> ${jurusan}</p>
                            <p><strong>Divisi:</strong> ${divisi}</p>
                            ${fileHtml}
                            <p class="mt-2"><strong>Isi Surat:</strong><br>${isi}</p>
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
                        title: 'Hapus Surat Keluar?',
                        text: "Data surat keluar akan dihapus secara permanen dan tidak dapat dikembalikan.",
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
