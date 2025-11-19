<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Detail Distribusi Zakat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2, h3 { margin-bottom: 6px; }
        .section { margin-bottom: 20px; page-break-inside: avoid; }
        .label { font-weight: bold; width: 160px; display: inline-block; }
        .value { display: inline-block; }
        .box { border: 1px solid #ccc; padding: 10px; border-radius: 6px; background: #f9f9f9; }
        .header { background: #6366f1; color: white; padding: 10px; border-radius: 6px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Rekap Detail Distribusi Zakat</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($start)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($end)->format('d M Y') }}</p>
    </div>

    @forelse($rekapDistribusi as $distribusi)
    <div class="section">
        <h3>📦 Distribusi #{{ $distribusi->id }}</h3>

        <div class="box">
            <p><span class="label">Tanggal:</span> {{ \Carbon\Carbon::parse($distribusi->tanggal)->format('d M Y') }}</p>
            <p><span class="label">Jenis Bantuan:</span> {{ $distribusi->jenisBantuan->nama_bantuan ?? '-' }}</p>
            <p><span class="label">Jumlah:</span> Rp{{ number_format($distribusi->jumlah, 0, ',', '.') }}</p>
        </div>

        <h4>👤 Data Mustahiq</h4>
        <div class="box">
            <p><span class="label">Nama Mustahiq:</span> {{ $distribusi->mustahik->nama ?? '-' }}</p>
        </div>

        @php
            $detail = is_array($distribusi->detail) ? $distribusi->detail : json_decode($distribusi->detail, true);
        @endphp
        @if(is_array($detail))
        <h4>📄 Detail Tambahan</h4>
        <div class="box">
            @foreach($detail as $key => $value)
                <p>
                    <span class="label">{{ \Illuminate\Support\Str::headline($key) }}:</span>
                    <span class="value">
                        @if($key === 'nominal')
                            Rp{{ number_format($value, 0, ',', '.') }}
                        @else
                            {{ $value }}
                        @endif
                    </span>
                </p>
            @endforeach
        </div>
        @endif
    </div>
    @empty
    <p>Tidak ada distribusi zakat pada periode ini.</p>
    @endforelse

</body>
</html>
