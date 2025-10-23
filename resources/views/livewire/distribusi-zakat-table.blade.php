<div>
    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-2">Mustahik</th>
                <th class="px-3 py-2">Jenis Bantuan</th>
                <th class="px-3 py-2">Jumlah</th>
                <th class="px-3 py-2">Tanggal</th>
                <th class="px-3 py-2">Detail</th>
                <th class="px-3 py-2">Status</th>
                <th class="px-3 py-2">Aksi</th> {{-- ✅ Kolom baru --}}
            </tr>
        </thead>
        <tbody>
            @foreach($distribusi as $d)
                @php
                    $detail = is_array($d->detail_json) ? $d->detail_json : json_decode($d->detail_json, true);
                    $slug = $d->jenisBantuan->slug ?? null;
                @endphp
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $d->mustahik->nama }}</td>
                    <td class="px-3 py-2">{{ $d->jenisBantuan->nama_bantuan }}</td>
                    <td class="px-3 py-2">{{ number_format($d->jumlah) }}</td>
                    <td class="px-3 py-2">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>

                    <td class="px-3 py-2">
                        @switch($slug)
                            @case('sembako')
                                Paket: {{ $detail['jumlah_paket'] ?? '-' }},
                                Barang: {{ $detail['jenis_barang'] ?? '-' }}
                                @break
                            @case('beasiswa')
                                Siswa: {{ $detail['nama_siswa'] ?? '-' }},
                                Jenjang: {{ $detail['jenjang'] ?? '-' }},
                                Nominal: Rp{{ number_format($detail['nominal'] ?? 0) }}
                                @break
                            @case('modal-usaha')
                                Usaha: {{ $detail['jenis_usaha'] ?? '-' }},
                                Modal: Rp{{ number_format($detail['modal'] ?? 0) }},
                                Pendampingan: {{ $detail['pendampingan'] ?? '-' }}
                                @break
                            @case('kesehatan')
                                Pasien: {{ $detail['nama_pasien'] ?? '-' }},
                                Pengobatan: {{ $detail['jenis_pengobatan'] ?? '-' }},
                                Biaya: Rp{{ number_format($detail['biaya'] ?? 0) }}
                                @break
                            @case('uang-tunai')
                                Penerima: {{ $detail['nama_penerima'] ?? '-' }},
                                Nominal: Rp{{ number_format($detail['nominal'] ?? 0) }},
                                Tujuan: {{ $detail['tujuan'] ?? '-' }}
                                @break
                            @default
                                -
                        @endswitch
                    </td>

                    <td class="px-3 py-2">{{ ucfirst($d->status) }}</td>

                    {{-- ✅ Tombol Aksi --}}
                    <td class="px-3 py-2 flex gap-2">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.distribusi.edit', $d->id) }}" class="text-blue-600 hover:underline text-sm">
                            ✏️ Edit
                        </a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.distribusi.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus distribusi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">
                                🗑️ Hapus
                            </button>
                        </form>

                        {{-- Tombol Detail --}}
                        <a href="{{ route('admin.distribusi.show', $d->id) }}" class="text-gray-700 hover:underline text-sm">
                            📄 Detail
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
