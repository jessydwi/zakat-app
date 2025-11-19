<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Detail Zakat Masuk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2, h3 { margin-bottom: 6px; }
        .section { margin-bottom: 20px; page-break-inside: avoid; }
        .label { font-weight: bold; width: 160px; display: inline-block; }
        .value { display: inline-block; }
        .box { border: 1px solid #ccc; padding: 10px; border-radius: 6px; background: #f9f9f9; }
        .header { background: #3b82f6; color: white; padding: 10px; border-radius: 6px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Rekap Detail Zakat Masuk</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($start)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($end)->format('d M Y') }}</p>
    </div>

    @forelse($rekapMasuk as $transaksi)
    <div class="section">
        <h3>🧾 Transaksi #{{ $transaksi->id }}</h3>

        <div class="box">
            <p><span class="label">Tanggal:</span> {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</p>
            <p><span class="label">Jenis Zakat:</span> {{ $transaksi->jenisZakat->nama_jenis ?? $transaksi->jenis_zakat }}</p>
            <p><span class="label">Metode Pembayaran:</span> {{ $transaksi->metodePembayaran->nama_metode ?? ucfirst($transaksi->metode_pembayaran ?? '-') }}</p>
            <p><span class="label">Jumlah:</span> Rp{{ number_format($transaksi->nominal ?? $transaksi->jumlah, 0, ',', '.') }}</p>
        </div>

        <h4>👤 Data Muzakki</h4>
        <div class="box">
            <p><span class="label">Nama Muzakki:</span> {{ $transaksi->muzakki->nama ?? $transaksi->nama }}</p>
            <p><span class="label">Jenis Kelamin:</span> {{ $transaksi->jenis_kelamin ?? '-' }}</p>
            <p><span class="label">Kontak:</span> {{ $transaksi->kontak ?? '-' }}</p>
        </div>

        @if($transaksi->amil && $transaksi->amil->user)
        <h4>✅ Petugas Konfirmasi</h4>
        <div class="box">
            <p><span class="label">Nama Amil:</span> {{ $transaksi->amil->user->nama }}</p>
            <p><span class="label">Jabatan:</span> {{ $transaksi->amil->jabatan ?? '-' }}</p>
            <p><span class="label">Wilayah Tugas:</span> {{ $transaksi->amil->wilayah_tugas ?? '-' }}</p>
        </div>
        @endif

        @php
            $detail = is_array($transaksi->detail) ? $transaksi->detail : json_decode($transaksi->detail, true);
        @endphp
        @if(is_array($detail))
        <h4>📦 Detail Tambahan</h4>
        <div class="box">
            @foreach($detail as $key => $value)
                <p>
                    <span class="label">{{ \Illuminate\Support\Str::headline($key) }}:</span>
                    <span class="value">
                        @if(in_array($key, ['nominal', 'nominal_fidyah']))
                            Rp{{ number_format($value, 0, ',', '.') }}
                        @elseif($key === 'jumlah_hari')
                            {{ $value }} hari
                        @else
                            {{ $value }}
                        @endif
                    </span>
                </p>
            @endforeach
        </div>
        @endif

        @if($transaksi->buktiPembayaran)
        <h4>📎 Bukti Pembayaran</h4>
        <div class="box">
            <p>File: {{ basename($transaksi->buktiPembayaran->file_path) }}</p>
        </div>
        @endif
    </div>
    @empty
    <p>Tidak ada transaksi zakat masuk pada periode ini.</p>
    @endforelse

</body>
</html>
