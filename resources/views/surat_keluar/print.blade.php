<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat Keluar - {{ $suratKeluar->nomor_surat_keluar ?? 'Draft' }}</title>
    <style>
        @page {
            margin: 4cm 3cm; /* Meningkatkan margin vertikal (atas/bawah) dan horizontal (kiri/kanan) */
        }

        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            margin: 0; 
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
            border-bottom: 2px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .header img {
            height: 70px;
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

        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 11pt;
        }

        .meta-info-left, .meta-info-right {
            width: 48%;
        }

        .meta-info-right {
            text-align: right;
        }

        .meta-item {
            margin-bottom: 5px;
        }

        .meta-label {
            font-weight: bold;
            display: inline-block;
            min-width: 80px;
        }

        .kepada-yth {
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 11pt;
            line-height: 1.4;
        }
        
        .kepada-yth p {
            margin: 0;
        }

        .isi-surat {
            margin-top: 20px;
            margin-bottom: 30px;
            text-align: justify;
            font-size: 11pt;
            line-height: 1.8;
        }
        
        .isi-surat p {
            text-indent: 0.5in;
            margin-bottom: 10px;
        }

        .salam-penutup {
            text-align: right;
            margin-top: 30px;
            font-size: 11pt;
        }

        .signature-block {
            margin-top: 40px;
            text-align: right;
            font-size: 11pt;
        }

        .signature-block p {
            margin: 0;
        }

        .signature-line {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }

        .footer-print {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 9pt;
            color: #666;
            padding-top: 10px;
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
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button">Cetak</button>
    
    <div class="header">
        <img src="{{ asset('icons/logo_pnp.png') }}" alt="Logo Instansi">
        <div class="header-text">
            <h1>POLITEKNIK NEGERI PADANG</h1>
            <h2>Jl. Kampus, Limau Manis, Kec. Pauh, Kota Padang, Sumatera Barat 25163</h2>
            <p>Telp: (0751) 72590 Fax: (0751) 72576</p>
            <p>Email: info@polinpdg.ac.id Website: www.polinpdg.ac.id</p>
        </div>
    </div>
    
    <div class="meta-info">
        <div class="meta-info-left">
            <div class="meta-item"><span class="meta-label">Nomor</span> : {{ $suratKeluar->nomor_surat_keluar ?? '-' }}</div>
            <div class="meta-item"><span class="meta-label">Sifat</span> : {{ $suratKeluar->sifat_surat ?? '-' }}</div>
            <div class="meta-item"><span class="meta-label">Perihal</span> : {{ $suratKeluar->perihal ?? '-' }}</div>
            <div class="meta-item"><span class="meta-label">Jenis</span> : {{ $suratKeluar->jenis_surat ?? '-' }}</div>
        </div>
        <div class="meta-info-right">
            Padang, {{ optional($suratKeluar->tanggal_surat)->format('d F Y') ?? '-' }}
        </div>
    </div>

    <div class="kepada-yth">
        <p>Kepada Yth.</p>
        <p><strong>{{ $suratKeluar->penerima ?? '-' }}</strong></p>
        <p>{{ $suratKeluar->tujuan_surat ?? '-' }}</p>
        <p>{{ $suratKeluar->alamat_tujuan ?? '-' }}</p>
        <p>di tempat</p>
    </div>

    <div class="isi-surat">
        <p>Dengan hormat,</p>
        <p>{!! nl2br(e($suratKeluar->isi_surat ?? '')) !!}</p>
        <p>Demikian surat ini kami sampaikan, atas perhatian dan kerja sama Saudara/i kami ucapkan terima kasih.</p>
    </div>
    
    <div class="salam-penutup">
        <p>Hormat kami,</p>
    </div>

    <div class="signature-block">
        <p>{{ $suratKeluar->pengirim ?? '' }}</p> {{-- Pengirim internal (Jabatan/Nama) --}}
        <div class="signature-line">
            {{ $suratKeluar->user->name ?? '-' }}
        </div>
        <p>NIP. .....................................</p>
    </div>
    
    {{-- Bagian tembusan dihapus --}}
    {{-- @if($suratKeluar->keterangan)
        <div class="tembusan">
            <p>Tembusan:</p>
            <p>{{ $suratKeluar->keterangan }}</p>
        </div>
    @endif --}}

    <div class="footer-print">
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
