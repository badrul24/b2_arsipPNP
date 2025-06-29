<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat Masuk - {{ $suratMasuk->nomor_surat_pengirim }}</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
        }
        
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            margin: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            font-weight: normal;
        }
        
        .content {
            margin-bottom: 30px;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .info-item {
            display: flex;
            margin-bottom: 8px;
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
        }
        
        .footer {
            margin-top: 50px;
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
        }
        
        .print-button:hover {
            background: #0056b3;
        }
        
        @media print {
            .print-button {
                display: none;
            }
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-diajukan { background-color: #dbeafe; color: #1e40af; }
        .status-diverifikasi { background-color: #fef3c7; color: #d97706; }
        .status-ditolak { background-color: #fee2e2; color: #dc2626; }
        .status-diproses { background-color: #e0e7ff; color: #7c3aed; }
        .status-disetujui { background-color: #d1fae5; color: #059669; }
        .status-terkirim { background-color: #f0f9ff; color: #0369a1; }
        .status-baru { background-color: #f3f4f6; color: #374151; }
        .status-dibaca { background-color: #fef3c7; color: #d97706; }
        .status-selesai { background-color: #d1fae5; color: #059669; }
        .status-diarsipkan { background-color: #f3f4f6; color: #6b7280; }
        .status-didisposisi { background-color: #fce7f3; color: #be185d; }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">Cetak</button>
    
    <div class="header">
        <h1>POLITEKNIK NEGERI PADANG</h1>
        <h2>SURAT MASUK</h2>
        <h2>Nomor Agenda: {{ $suratMasuk->nomor_agenda ?? '-' }}</h2>
    </div>
    
    <div class="content">
        <div class="section">
            <div class="section-title">INFORMASI SURAT</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nomor Surat:</span>
                    <span class="info-value">{{ $suratMasuk->nomor_surat_pengirim }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Surat:</span>
                    <span class="info-value">{{ optional($suratMasuk->tanggal_surat_pengirim)->format('d-m-Y') ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Pengirim:</span>
                    <span class="info-value">{{ $suratMasuk->pengirim }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Terima:</span>
                    <span class="info-value">{{ optional($suratMasuk->tanggal_terima)->format('d-m-Y') ?? '-' }}</span>
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
                    <span class="info-label">Perihal:</span>
                    <span class="info-value">{{ $suratMasuk->perihal }}</span>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">INFORMASI PENGIRIM</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Jurusan:</span>
                    <span class="info-value">{{ $suratMasuk->jurusan->nama_jurusan ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Pengirim:</span>
                    <span class="info-value">{{ $suratMasuk->user->name ?? '-' }}</span>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">KETERANGAN</div>
            <div class="surat-content">
                <div class="info-item">
                    <span class="info-label">Keterangan:</span>
                    <span class="info-value">{{ $suratMasuk->keterangan ?? 'Tidak ada keterangan' }}</span>
                </div>
            </div>
        </div>
        
        @if($suratMasuk->file_surat_path)
        <div class="section">
            <div class="section-title">LAMPIRAN</div>
            <div class="info-item">
                <span class="info-label">File Surat:</span>
                <span class="info-value">{{ $suratMasuk->nama_file_surat_asli ?? 'File terlampir' }}</span>
            </div>
        </div>
        @endif
        
        @if($suratMasuk->disposisis && $suratMasuk->disposisis->count() > 0)
        <div class="section">
            <div class="section-title">DISPOSISI</div>
            @foreach($suratMasuk->disposisis as $index => $disposisi)
            <div class="surat-content" style="margin-bottom: 10px;">
                <div class="info-item">
                    <span class="info-label">Disposisi #{{ $index + 1 }}:</span>
                    <span class="info-value">{{ $disposisi->isi_disposisi }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Pemberi:</span>
                    <span class="info-value">{{ $disposisi->userPemberi->name ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal:</span>
                    <span class="info-value">{{ optional($disposisi->tanggal_disposisi)->format('d-m-Y') ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">{{ $disposisi->status_disposisi }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    
    <div class="footer">
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">
                    <strong>Penerima Surat</strong><br>
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
        // Auto-print when page loads
        window.onload = function() {
            // Small delay to ensure page is fully loaded
            setTimeout(function() {
                window.print();
            }, 500);
        };
        
        // Handle print button click
        function printDocument() {
            window.print();
        }
    </script>
</body>
</html> 