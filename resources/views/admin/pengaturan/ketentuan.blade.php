@extends('layouts.admin')

@section('title', 'Pengaturan Ketentuan Zakat')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6 space-y-6">
    <h1 class="text-2xl font-bold text-blue-800">Pengaturan Ketentuan Zakat</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Tambah Ketentuan --}}
    <form method="POST" action="{{ route('admin.ketentuan.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Jenis Zakat</label>
            <select name="jenis_zakat" id="jenis_zakat" onchange="updateFormFields()" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Jenis Zakat --</option>
                <option value="fitrah">Zakat Fitrah</option>
                <option value="penghasilan">Zakat Penghasilan</option>
                <option value="mal">Zakat Mal</option>
            </select>
        </div>

        <div id="dynamic-fields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Diisi oleh JavaScript --}}
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
            <textarea name="keterangan" rows="3" placeholder="Penjelasan opsional..." class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <div class="md:col-span-2 text-right">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                💾 Simpan Ketentuan
            </button>
        </div>
    </form>

    {{-- Tabel Zakat Fitrah --}}
    @if(isset($data['fitrah']))
        <div class="mt-10">
            <h2 class="text-lg font-semibold text-green-700 mb-2">🧺 Zakat Fitrah</h2>
            <div class="overflow-x-auto">
                <table class="w-full table-auto border text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-3 py-2 text-left">Metode</th>
            <th class="px-3 py-2 text-left">Nilai</th>
            <th class="px-3 py-2 text-left">Satuan</th>
            <th class="px-3 py-2 text-left">Keterangan</th>
            <th class="px-3 py-2 text-left">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['fitrah'] as $item)
        <tr class="border-t hover:bg-gray-50">
            <td class="px-3 py-2">
                {{ $item->parameter === 'harga_beras' ? 'Beras' : 'Uang' }}
            </td>
            <td class="px-3 py-2">
                @if($item->parameter === 'harga_uang')
                    {{ 'Rp ' . number_format($item->nilai, 0, ',', '.') }}
                @else
                    {{ number_format($item->nilai, 2, ',', '.') }}
                @endif
            </td>
            <td class="px-3 py-2">{{ $item->satuan }}</td>
            <td class="px-3 py-2">{{ $item->keterangan ?? '-' }}</td>
            <td class="px-3 py-2">
                <form method="POST" action="{{ route('admin.ketentuan.destroy', $item->id) }}" onsubmit="return confirm('Yakin ingin menghapus ketentuan ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline text-sm">🗑️ Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
            </div>
        </div>
    @endif

    {{-- Tabel Zakat Penghasilan --}}
@if(isset($data['penghasilan']))
    <div class="mt-10">
        <h2 class="text-lg font-semibold text-indigo-700 mb-2">💼 Zakat Penghasilan</h2>
        <div class="overflow-x-auto">
    <table class="w-full table-auto border text-sm">
        <thead class="bg-gray-100 text-indigo-800 font-semibold">
            <tr>
                <th class="px-3 py-2 text-left">Jenis Parameter</th>
                <th class="px-3 py-2 text-left">Nilai</th>
                <th class="px-3 py-2 text-left">Satuan</th>
                <th class="px-3 py-2 text-left">Keterangan</th>
                <th class="px-3 py-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['penghasilan'] as $item)
            <tr class="border-t hover:bg-indigo-50">
                <td class="px-3 py-2 font-medium text-gray-700">
                    @switch($item->parameter)
                        @case('persentase') Persentase Zakat @break
                        @case('nisab_tahun') Nisab Tahunan @break
                        @case('nisab_bulan') Nisab Bulanan @break
                        @default {{ ucfirst($item->parameter) }}
                    @endswitch
                </td>
                <td class="px-3 py-2 text-gray-800">{{ number_format($item->nilai, 2, ',', '.') }}</td>
                <td class="px-3 py-2 text-gray-800">{{ $item->satuan }}</td>
                <td class="px-3 py-2 text-gray-800">{{ $item->keterangan ?? '-' }}</td>
                <td class="px-3 py-2">
                    <form method="POST" action="{{ route('admin.ketentuan.destroy', $item->id) }}" onsubmit="return confirm('Yakin ingin menghapus ketentuan ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline text-sm">🗑️ Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    </div>
@endif

    {{-- Tabel Zakat Mal --}}
    @if(isset($data['mal']))
        <div class="mt-10">
            <h2 class="text-lg font-semibold text-yellow-700 mb-2">🏦 Zakat Mal</h2>
            <div class="overflow-x-auto">
                <table class="w-full table-auto border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left">Parameter</th>
                            <th class="px-3 py-2 text-left">Nilai</th>
                            <th class="px-3 py-2 text-left">Satuan</th>
                            <th class="px-3 py-2 text-left">Uang</th>
                            <th class="px-3 py-2 text-left">Keterangan</th>
                            <th class="px-3 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['mal'] as $item)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-3 py-2">{{ $item->parameter }}</td>
                            <td class="px-3 py-2">{{ number_format($item->nilai, 2, ',', '.') }}</td>
                            <td class="px-3 py-2">{{ $item->satuan }}</td>
                            <td class="px-3 py-2">{{ $item->nilai_uang ? 'Rp ' . number_format($item->nilai_uang, 0, ',', '.') : '-' }}</td>
                            <td class="px-3 py-2">{{ $item->keterangan }}</td>
                            <td class="px-3 py-2">
                                        <form method="POST" action="{{ route('admin.ketentuan.destroy', $item->id) }}" onsubmit="return confirm('Yakin ingin menghapus ketentuan ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:underline text-sm">🗑️ Hapus</button>
                                        </form>
                                    </td>
                                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
<script>
function updateFormFields() {
    const jenis = document.getElementById('jenis_zakat').value;
    const container = document.getElementById('dynamic-fields');
    container.innerHTML = '';

    if (jenis === 'fitrah') {
        container.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis Pembayaran</label>
                <select name="parameter" id="parameter_fitrah" onchange="updateFitrahFields()" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Metode --</option>
                    <option value="harga_beras">Beras</option>
                    <option value="harga_uang">Uang</option>
                </select>
            </div>
            <div id="fitrah-fields" class="grid grid-cols-1 md:grid-cols-2 gap-6 md:col-span-2"></div>
        `;
    } else if (jenis === 'penghasilan') {
    container.innerHTML = `
        <div class="md:col-span-2">
            <h3 class="text-md font-semibold text-indigo-600 mb-2">Persentase Zakat</h3>
        </div>
        <input type="hidden" name="parameter" value="persentase">
        <div>
            <label class="block text-sm font-medium text-gray-700">Satuan</label>
            <input type="text" name="satuan" value="%" class="w-full border rounded-lg px-4 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nilai Persentase</label>
            <input type="number" name="nilai" step="0.01" value="2.5" class="w-full border rounded-lg px-4 py-2">
        </div>
        <div class="md:col-span-2">
            <h3 class="text-md font-semibold text-indigo-600 mt-6 mb-2">Nisab Tahunan</h3>
        </div>
        <input type="hidden" name="parameter_tahun" value="nisab_tahun">
        <div>
            <label class="block text-sm font-medium text-gray-700">Satuan</label>
            <input type="text" name="satuan_tahun" value="rupiah" class="w-full border rounded-lg px-4 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nilai Tahunan</label>
            <input type="number" name="nilai_tahun" step="100" value="85685972" class="w-full border rounded-lg px-4 py-2">
        </div>
        <div class="md:col-span-2">
            <h3 class="text-md font-semibold text-indigo-600 mt-6 mb-2">Nisab Bulanan</h3>
        </div>
        <input type="hidden" name="parameter_bulan" value="nisab_bulan">
        <div>
            <label class="block text-sm font-medium text-gray-700">Satuan</label>
            <input type="text" name="satuan_bulan" value="rupiah" class="w-full border rounded-lg px-4 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nilai Bulanan</label>
            <input type="number" name="nilai_bulan" step="100" value="7140498" class="w-full border rounded-lg px-4 py-2">
        </div>
    `;
    } else if (jenis === 'mal') {
        container.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700">Parameter</label>
                <input type="text" name="parameter" value="nisab" readonly class="w-full border rounded-lg px-4 py-2 bg-gray-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Satuan</label>
                <input type="text" name="satuan" value="gram" class="w-full border rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nilai</label>
                <input type="number" name="nilai" step="0.01" placeholder="Contoh: 85" class="w-full border rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nilai dalam Rupiah</label>
                <input type="number" name="nilai_uang" step="100" class="w-full border rounded-lg px-4 py-2">
            </div>
        `;
    }
}

function updateFitrahFields() {
    const metode = document.getElementById('parameter_fitrah').value;
    const target = document.getElementById('fitrah-fields');
    target.innerHTML = '';

   if (metode === 'harga_beras') {
    target.innerHTML = `
        <input type="hidden" name="parameter" value="harga_beras">
        <div>
            <label class="block text-sm font-medium text-gray-700">Satuan</label>
            <input type="text" name="satuan" value="kg" class="w-full border rounded-lg px-4 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nilai (kg)</label>
            <input type="number" name="nilai" step="0.01" placeholder="Contoh: 2.5" class="w-full border rounded-lg px-4 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Konversi ke Rupiah (opsional)</label>
            <input type="number" name="nilai_uang" step="100" placeholder="Contoh: 45000" class="w-full border rounded-lg px-4 py-2">
        </div>
    `;
} else if (metode === 'harga_uang') {
    target.innerHTML = `
        <input type="hidden" name="parameter" value="harga_uang">
        <div>
            <label class="block text-sm font-medium text-gray-700">Satuan</label>
            <input type="text" name="satuan" value="rupiah" class="w-full border rounded-lg px-4 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nilai (rupiah)</label>
            <input type="number" name="nilai" step="100" placeholder="Contoh: 45000" class="w-full border rounded-lg px-4 py-2">
        </div>
    `;
}
}

function updatePenghasilanDefaults() {
    const param = document.getElementById('parameter_penghasilan').value;
    const nilai = document.getElementById('nilai_penghasilan');
    const satuan = document.getElementById('satuan_penghasilan');

    if (param === 'persentase') {
        nilai.value = 2.5;
        satuan.value = '%';
    } else if (param === 'nisab_tahun') {
        nilai.value = 85685972;
        satuan.value = 'rupiah';
    } else if (param === 'nisab_bulan') {
        nilai.value = 7140498;
        satuan.value = 'rupiah';
    } else {
        nilai.value = '';
        satuan.value = '';
    }
}
</script>

@endsection

