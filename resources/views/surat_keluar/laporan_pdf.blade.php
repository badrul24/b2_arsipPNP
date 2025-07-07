<!DOCTYPE html>
<html>
<head>
    <title>Laporan Surat Keluar</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header .logo {
            width: 60px;
            margin-bottom: 4px;
        }
        .header .instansi {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .header .alamat {
            font-size: 11px;
            margin-bottom: 0;
        }
        .header .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
            margin-top: 24px;
        }
        .divider {
            border-bottom: 2.5px solid #333;
            margin-bottom: 18px;
            margin-top: 8px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px 4px; }
        th { background: #f3f3f3; font-size: 12px; }
        td { font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('icons/logo.png') }}" class="logo" alt="Logo">
        <div class="instansi">POLITEKNIK NEGERI PADANG</div>
        <div class="alamat">Jl. Limau Manis, Pauh, Padang, Sumatera Barat 25164</div>
        <div class="divider"></div>
        <div class="title">LAPORAN SURAT KELUAR</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Tanggal</th>
                <th>Perihal</th>
                <th>Dari</th>
                <th>Penerima</th>
                <th>Jenis</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suratKeluars as $i => $surat)
            <tr>
                <td style="text-align:center;">{{ $i+1 }}</td>
                <td>{{ $surat->nomor_surat_keluar }}</td>
                <td>{{ optional($surat->tanggal_surat)->format('d-m-Y') }}</td>
                <td>{{ $surat->perihal }}</td>
                <td>{{ $surat->user->name ?? '-' }}</td>
                <td>{{ $surat->penerima }}</td>
                <td>{{ $surat->jenis_surat }}</td>
                <td>{{ $surat->status_surat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @php
        $user = Auth::user();
    @endphp
    <div style="margin-top:40px; text-align:right; font-size:12px;">
        Padang, {{ date('d-m-Y') }}<br>
        <span style="font-size:11px;">Dicetak oleh: {{ $user->name }} ({{ ucfirst(str_replace('_', ' ', $user->role)) }})</span>
    </div>
</body>
</html> 