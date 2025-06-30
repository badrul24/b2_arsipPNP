<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat Masuk - {{ $suratMasuk->nomor_surat_pengirim ?? 'Tidak Ada Nomor' }}</title>
    <style>
        @page {
            margin: 3.5cm 3cm; /* Margin yang lebih baik untuk cetak: atas/bawah 3.5cm, kiri/kanan 3cm */
        }

        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            margin: 0; /* Mengatur margin body ke 0 agar @page dapat mengontrol penuh margin cetak */
            color: #000;
            font-size: 12pt;
        }
        
        .no-print {
            display: none !important;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000; /* Garis pemisah kop surat */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .header img {
            height: 70px; /* Ukuran logo */
            margin-right: 15px;
        }
        
        .header-text {
            text-align: center;
            flex-grow: 1;
        }

        .header-text h1 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .header-text h2 {
            margin: 2px 0;
            font-size: 14pt;
            font-weight: normal;
        }
        
        .header-text p {
            margin: 0;
            font-size: 10pt;
        }

        .content {
            margin-bottom: 0;
        }
        
        .section {
            margin-bottom: 10px;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 8px; /* Mengurangi margin bawah judul section */
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5px; /* Mengurangi jarak antar item dalam grid secara vertikal dan horizontal */
            margin-bottom: 0;
        }
        
        .info-item {
            display: flex;
            margin-bottom: 3px; /* Mengurangi margin bawah setiap info-item agar lebih rapat */
            align-items: baseline;
        }
        
        .info-label {
            font-weight: bold;
            min-width: 120px;
            margin-right: 10px;
        }
        
        .info-value {
            flex: 1;
        }
        
        .surat-content {
            border: 1px solid #333;
            padding: 15px;
            margin: 15px 0;
            background-color: #f9f9f9;
            font-size: 11pt;
        }
        
        .footer {
            margin-top: 40px;
            text-align: right;
        }
        
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 5px;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
        
        @media print {
            .print-button {
                display: none;
            }
            body { 
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .status-diajukan { background-color: #dbeafe; color: #1e40af; }
        .status-diverifikasi { background-color: #d1fae5; color: #059669; }
        .status-ditolak { background-color: #fee2e2; color: #dc2626; }
        .status-diproses { background-color: #fef3c7; color: #d97706; }
        .status-disetujui { background-color: #d1fae5; color: #059669; }
        .status-terkirim { background-color: #e0e7ff; color: #4338ca; }
        .status-baru { background-color: #e2e8f0; color: #4b5563; }
        .status-dibaca { background-color: #fef3c7; color: #d97706; }
        .status-selesai { background-color: #bfdbfe; color: #1d4ed8; }
        .status-diarsipkan { background-color: #d1d5db; color: #4b5563; }

        .multi-select-print {
            padding-left: 20px;
            margin-top: 5px;
        }
        .multi-select-print ul {
            list-style: disc;
            margin: 0;
            padding: 0;
        }
        .multi-select-print li {
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">Cetak</button>
    
    <div class="header">
        <img src="{{ asset('icons/logo.png') }}" alt="Logo Instansi">
        <div class="header-text">
            <h1>POLITEKNIK NEGERI PADANG</h1>
            <h2>Jl. Kampus, Limau Manis, Kec. Pauh, Kota Padang, Sumatera Barat 25163</h2>
            <p>Telp: (0751) 72590 Fax: (0751) 72576</p>
            <p>Email: info@polinpdg.ac.id Website: www.polinpdg.ac.id</p>
        </div>
    </div>
    
    <div class="content">
        <div class="section">
            <div class="section-title">INFORMASI SURAT MASUK</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nomor Agenda:</span>
                    <span class="info-value">{{ $suratMasuk->nomor_agenda ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nomor Surat:</span>
                    <span class="info-value">{{ $suratMasuk->nomor_surat_pengirim ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Surat:</span>
                    <span class="info-value">{{ optional($suratMasuk->tanggal_surat_pengirim)->format('d-m-Y') ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Terima:</span>
                    <span class="info-value">{{ optional($suratMasuk->tanggal_terima)->format('d-m-Y') ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Pengirim:</span>
                    <span class="info-value">{{ $suratMasuk->pengirim ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Perihal:</span>
                    <span class="info-value">{{ $suratMasuk->perihal ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Sifat Surat:</span>
                    <span class="info-value">{{ $suratMasuk->sifat_surat ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $suratMasuk->status_surat)) }}">
                            {{ $suratMasuk->status_surat }}
                        </span>
                    </span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Keterangan:</span>
                    <span class="info-value">{{ $suratMasuk->keterangan ?? 'Tidak ada keterangan.' }}</span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">File:</span>
                    <span class="info-value">
                        @if($suratMasuk->file_surat_path)
                            <a href="{{ asset($suratMasuk->file_surat_path) }}" target="_blank" style="color: #007bff; text-decoration: underline;">
                                {{ $suratMasuk->nama_file_surat_asli ?? 'Lihat File' }}
                            </a>
                        @else
                            Tidak ada file terlampir.
                        @endif
                    </span>
                </div>
            </div>
        </div>
        
        @if($suratMasuk->disposisis && $suratMasuk->disposisis->count() > 0)
        <div class="section">
            <div class="section-title">RIWAYAT DISPOSISI</div>
            @foreach($suratMasuk->disposisis as $index => $disposisi)
            <div class="surat-content" style="margin-bottom: 15px;">
                <h4>Disposisi #{{ $index + 1 }}</h4>
                <div class="info-item">
                    <span class="info-label">Pemberi:</span>
                    <span class="info-value">{{ $disposisi->userPemberi->name ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal:</span>
                    <span class="info-value">{{ optional($disposisi->tanggal_disposisi)->format('d-m-Y H:i') ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $disposisi->status_disposisi)) }}">
                            {{ $disposisi->status_disposisi }}
                        </span>
                    </span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Penerima:</span>
                    <span class="info-value">
                        @php
                            $penerima = [];
                            if ($disposisi->userPenerima) $penerima[] = $disposisi->userPenerima->name;
                            if ($disposisi->divisiPenerima) $penerima[] = 'Divisi: '.$disposisi->divisiPenerima->nama_divisi;
                            if ($disposisi->jurusanPenerima) $penerima[] = 'Jurusan: '.$disposisi->jurusanPenerima->nama_jurusan;
                        @endphp
                        {{ $penerima ? implode(', ', $penerima) : '-' }}
                    </span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Instruksi Kepada:</span>
                    <span class="info-value">
                        @if($disposisi->instruksi_kepada)
                            <div class="multi-select-print">
                                <ul>
                                    @foreach($disposisi->getInstruksiKepadaArray() as $instruksi)
                                        <li>{{ $instruksi }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Petunjuk:</span>
                    <span class="info-value">
                        @if($disposisi->petunjuk_disposisi)
                            <div class="multi-select-print">
                                <ul>
                                    @foreach($disposisi->getPetunjukDisposisiArray() as $petunjuk)
                                        <li>{{ $petunjuk }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Isi Disposisi:</span>
                    <span class="info-value">{{ $disposisi->isi_disposisi ?? '-' }}</span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Catatan:</span>
                    <span class="info-value">{{ $disposisi->catatan ?? '-' }}</span>
                </div>
                @if($disposisi->parentDisposisi)
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Dari Disposisi:</span>
                    <span class="info-value">#{{ $disposisi->parentDisposisi->id }} ({{ Str::limit($disposisi->parentDisposisi->isi_disposisi, 50) }})</span>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
    
    <div class="footer">
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">
                    <strong>Petugas Penginput</strong><br>
                    <small>Nama & Tanda Tangan</small>
                </div>
            </div>
            <div class="signature-box">
                <div class="signature-line">
                    <strong>Penyimpan Arsip</strong><br>
                    <small>Nama & Tanda Tangan</small>
                </div>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 30px; font-size: 12px; text-align: center; color: #666;">
        <p>Dokumen ini dicetak pada: {{ now()->format('d-m-Y H:i:s') }}</p>
        <p>Sistem Arsip Digital - Politeknik Negeri Padang</p>
    </div>
    
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
