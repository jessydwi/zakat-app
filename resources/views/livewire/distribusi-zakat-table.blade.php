<div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-shadow duration-300">
    <div class="flex items-center gap-3 mb-6">
        <i class="fas fa-table text-emerald-600 text-2xl"></i>
        <h2 class="text-lg font-semibold text-emerald-800">Tabel Distribusi Zakat</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-emerald-100">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-emerald-800 rounded-tl-lg">Mustahik</th>
                    <th class="px-4 py-3 text-left font-semibold text-emerald-800">Jenis Bantuan</th>
                    <th class="px-4 py-3 text-left font-semibold text-emerald-800">Jumlah</th>
                    <th class="px-4 py-3 text-left font-semibold text-emerald-800">Tanggal</th>
                    <th class="px-4 py-3 text-left font-semibold text-emerald-800">Detail</th>
                    <th class="px-4 py-3 text-left font-semibold text-emerald-800">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-emerald-800 rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($distribusi as $d)
                    @php
                        $detail = is_array($d->detail_json) ? $d->detail_json : json_decode($d->detail_json, true);
                        $slug = $d->jenisBantuan->slug ?? null;
                    @endphp
                    <tr class="border-b border-gray-200 hover:bg-emerald-50 transition-colors duration-200">
                        <td class="px-4 py-3 text-gray-700">{{ $d->mustahik->nama }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $d->jenisBantuan->nama_bantuan }}</td>
                        <td class="px-4 py-3 text-gray-700 font-medium">Rp{{ number_format($d->jumlah) }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-gray-700">
                            @switch($slug)
                                @case('sembako')
                                    <div class="text-xs">
                                        <strong>Paket:</strong> {{ $detail['jumlah_paket'] ?? '-' }}<br>
                                        <strong>Barang:</strong> {{ $detail['jenis_barang'] ?? '-' }}
                                    </div>
                                    @break
                                @case('beasiswa')
                                    <div class="text-xs">
                                        <strong>Siswa:</strong> {{ $detail['nama_siswa'] ?? '-' }}<br>
                                        <strong>Jenjang:</strong> {{ $detail['jenjang'] ?? '-' }}<br>
                                        <strong>Nominal:</strong> Rp{{ number_format($detail['nominal'] ?? 0) }}
                                    </div>
                                    @break
                                @case('modal-usaha')
                                    <div class="text-xs">
                                        <strong>Usaha:</strong> {{ $detail['jenis_usaha'] ?? '-' }}<br>
                                        <strong>Modal:</strong> Rp{{ number_format($detail['modal'] ?? 0) }}<br>
                                        <strong>Pendampingan:</strong> {{ $detail['pendampingan'] ?? '-' }}
                                    </div>
                                    @break
                                @case('kesehatan')
                                    <div class="text-xs">
                                        <strong>Pasien:</strong> {{ $detail['nama_pasien'] ?? '-' }}<br>
                                        <strong>Pengobatan:</strong> {{ $detail['jenis_pengobatan'] ?? '-' }}<br>
                                        <strong>Biaya:</strong> Rp{{ number_format($detail['biaya'] ?? 0) }}
                                    </div>
                                    @break
                                @case('uang-tunai')
                                    <div class="text-xs">
                                        <strong>Penerima:</strong> {{ $detail['nama_penerima'] ?? '-' }}<br>
                                        <strong>Nominal:</strong> Rp{{ number_format($detail['nominal'] ?? 0) }}<br>
                                        <strong>Tujuan:</strong> {{ $detail['tujuan'] ?? '-' }}
                                    </div>
                                    @break
                                @default
                                    -
                            @endswitch
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                @if($d->status == 'selesai') bg-green-100 text-green-800 
                                @elseif($d->status == 'proses') bg-yellow-100 text-yellow-800 
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($d->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.distribusi.edit', $d->id) }}" 
                                   class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition-all duration-300 transform hover:scale-105 text-xs flex items-center gap-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.distribusi.destroy', $d->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus distribusi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition-all duration-300 transform hover:scale-105 text-xs flex items-center gap-1">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>

                                {{-- Tombol Detail --}}
                                <a href="{{ route('admin.distribusi.show', $d->id) }}" 
                                   class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600 transition-all duration-300 transform hover:scale-105 text-xs flex items-center gap-1">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($distribusi->isEmpty())
        <div class="text-center py-8">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500">Tidak ada data distribusi.</p>
        </div>
    @endif
</div>
