@extends('layouts.admin')

@section('title', 'Tambah Pembayaran Zakat')

@section('content')
<div class="bg-gradient-to-br from-green-50 to-emerald-50 p-10 rounded-3xl shadow-md max-w-4xl mx-auto space-y-10 transition hover:shadow-xl animate-fade-in-up">

    <!-- Header -->
    <div class="text-center space-y-2">
        <h2 class="text-3xl font-extrabold text-emerald-700 flex items-center justify-center gap-3">
            <i class="fas fa-hand-holding-dollar text-emerald-500"></i>
            Tambah Pembayaran Zakat
        </h2>
        <p class="text-emerald-600 text-lg font-medium">Lengkapi data berikut untuk menambahkan pembayaran zakat, infak, atau sedekah.</p>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.transaksi.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- Nama Muzakki -->
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
            <label for="muzakki_id" class="block font-semibold text-emerald-700 mb-3 text-lg">
                <i class="fas fa-user text-emerald-500 mr-2"></i> Nama Muzakki
            </label>
            <select name="muzakki_id" id="muzakki_id" class="input-style" required>
                <option value="">-- Pilih Muzakki --</option>
                @foreach($muzakki as $m)
                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Nama Lengkap -->
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
            <label for="nama" class="block font-semibold text-emerald-700 mb-3 text-lg">
                <i class="fas fa-user text-emerald-500 mr-2"></i> Nama Lengkap
            </label>
            <input type="text" name="nama" id="nama"
                class="input-style"
                placeholder="Masukkan nama lengkap" required>
        </div>

        <!-- Jenis Kelamin -->
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
            <label for="jenis_kelamin" class="block font-semibold text-emerald-700 mb-3 text-lg">
                <i class="fas fa-venus-mars text-emerald-500 mr-2"></i> Jenis Kelamin
            </label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="input-style" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <!-- Kontak -->
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
            <label for="kontak" class="block font-semibold text-emerald-700 mb-3 text-lg">
                <i class="fas fa-phone text-emerald-500 mr-2"></i> Nomor HP / Email
            </label>
            <input type="text" name="kontak" id="kontak"
                class="input-style"
                placeholder="Contoh: 081234567890 atau email@domain.com" required>
        </div>

        <!-- Pilihan Jenis Zakat -->
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
            <label for="jenis_zakat_id" class="block font-semibold text-emerald-700 mb-3 text-lg">
                <i class="fas fa-donate text-emerald-500 mr-2"></i> Jenis Dana
            </label>
            <select name="jenis_zakat_id" id="jenis_zakat_id"
                class="input-style text-gray-700 text-base"
                onchange="tampilkanFormKhusus()" required>
                <option value="">-- Pilih Jenis Dana --</option>
                @foreach($jenisZakat as $j)
                    <option value="{{ $j->id }}" data-nama="{{ strtolower($j->nama_jenis) }}">
                        {{ $j->nama_jenis }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Form Khusus Berdasarkan Jenis -->
        <div id="formKhusus" class="space-y-4 hidden animate-fade-in-up"></div>

        <!-- Metode Pembayaran -->
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
            <label for="metode_id" class="block font-semibold text-emerald-700 mb-3 text-lg">
                <i class="fas fa-credit-card text-emerald-500 mr-2"></i> Metode Pembayaran
            </label>
            <div id="instruksiMetode" class="space-y-4 hidden animate-fade-in-up"></div>
            <select name="metode_id" class="input-style" onchange="tampilkanInstruksiMetode()" required>
                <option value="">-- Pilih Metode Pembayaran --</option>
                @foreach($metode as $m)
                    <option value="{{ $m->id }}">{{ $m->nama_metode }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tanggal Transaksi -->
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
            <label for="tanggal" class="block font-semibold text-emerald-700 mb-3 text-lg">
                <i class="fas fa-calendar-alt text-emerald-500 mr-2"></i> Tanggal Transaksi
            </label>
            <input type="date" name="tanggal" id="tanggal" class="input-style" required>
        </div>

        <!-- Tombol Submit -->
        <div class="pt-2">
            <button type="submit"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg">
                <i class="fas fa-paper-plane"></i> Simpan Pembayaran
            </button>
        </div>
    </form>
</div>

<script>
function tampilkanFormKhusus() {
    const select = document.getElementById('jenis_zakat_id');
    const selectedOption = select.options[select.selectedIndex];
    const jenis = selectedOption.dataset.nama;
    const container = document.getElementById('formKhusus');

    container.innerHTML = '';
    container.classList.add('hidden');
    if (!jenis) return;

    let html = '';

    // ==== Zakat Maal ====
    if (jenis.includes('maal')) {
        html = `
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition space-y-4">
            <h3 class="text-emerald-700 font-bold text-lg flex items-center gap-2"><i class="fas fa-gem text-emerald-500"></i> Detail Zakat Maal</h3>
            <div>
                <label class="label"><i class="fas fa-ring text-emerald-500 mr-1"></i> Nilai Emas / Perak / Permata</label>
                <input type="number" name="emas" class="input-style" placeholder="Masukkan nilai aset emas/perak" required>
            </div>
            <div>
                <label class="label"><i class="fas fa-piggy-bank text-emerald-500 mr-1"></i> Uang Tunai / Tabungan</label>
                <input type="number" name="tabungan" class="input-style" placeholder="Masukkan total tabungan" required>
            </div>
            <div>
                <label class="label"><i class="fas fa-car text-emerald-500 mr-1"></i> Aset Lain (Rumah, Kendaraan, dll)</label>
                <input type="number" name="aset_lain" class="input-style" placeholder="Masukkan nilai aset lainnya" required>
            </div>
            <div>
                <label class="label"><i class="fas fa-file-invoice-dollar text-emerald-500 mr-1"></i> Hutang / Cicilan (Opsional)</label>
                <input type="number" name="hutang" class="input-style" placeholder="Masukkan jumlah hutang jika ada">
            </div>
            <div>
                <label class="label"><i class="fas fa-money-bill-wave text-emerald-500 mr-1"></i> Nominal Zakat Maal</label>
                <input type="number" name="nominal" class="input-style" placeholder="Masukkan nominal zakat maal" required>
            </div>
        </div>
        `;
    }

    // ==== Fidyah ====
    else if (jenis.includes('fidyah')) {
        html = `
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition space-y-4">
            <h3 class="text-emerald-700 font-bold text-lg flex items-center gap-2"><i class="fas fa-bread-slice text-emerald-500"></i> Detail Zakat Fidyah</h3>
            <div>
                <label class="label"><i class="fas fa-calendar-day text-emerald-500 mr-1"></i> Jumlah Hari</label>
                <input type="number" name="jumlah_hari" class="input-style" placeholder="Masukkan jumlah hari" required>
            </div>
            <div>
                <label class="label"><i class="fas fa-coins text-emerald-500 mr-1"></i> Nominal Fidyah per Hari</label>
                <input type="number" name="nominal_fidyah" class="input-style" placeholder="Masukkan nominal per hari" required>
            </div>
            <div>
                <label class="label"><i class="fas fa-money-bill-wave text-emerald-500 mr-1"></i> Nominal Total Fidyah</label>
                <input type="number" name="nominal" class="input-style" placeholder="Masukkan nominal total fidyah" required>
            </div>
        </div>
        `;
    }

    // ==== Infak / Sedekah ====
   else if (jenis.includes('infak')) {
    html = `
    <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition space-y-4">
        <h3 class="text-emerald-700 font-bold text-lg flex items-center gap-2"><i class="fas fa-hand-holding-heart text-emerald-500"></i> Detail Sedekah</h3>
        <div>
            <label class="label"><i class="fas fa-hands-helping text-emerald-500 mr-1"></i> Tujuan Sedekah</label>
            <select name="tujuan_sedekah" class="input-style" required>
                <option value="">-- Pilih Tujuan --</option>
                <option value="palestina">Sedekah Palestina</option>
                <option value="anak-yatim">Anak Yatim</option>
                <option value="masjid">Masjid & Dakwah</option>
            </select>
        </div>
        <div>
            <label class="label"><i class="fas fa-donate text-emerald-500 mr-1"></i> Nominal Sedekah</label>
            <input type="number" name="nominal_sedekah" class="input-style" placeholder="Masukkan nominal sedekah" required>
        </div>
    </div>
    `;
}

    // ==== Zakat Fitrah / Lainnya ====
    else {
        html = `
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition space-y-4">
            <h3 class="text-emerald-700 font-bold text-lg flex items-center gap-2"><i class="fas fa-wheat-awn text-emerald-500"></i> Detail Zakat Fitrah</h3>
            <div>
                <label class="label"><i class="fas fa-money-bill-wave text-emerald-500 mr-1"></i> Nominal Zakat</label>
                <input type="number" name="nominal" class="input-style" placeholder="Masukkan nominal zakat" required>
            </div>
        </div>
        `;
    }

    container.innerHTML = html;
    container.classList.remove('hidden');
}

function tampilkanInstruksiMetode() {
    const select = document.querySelector('select[name="metode_id"]');
    const selected = select.options[select.selectedIndex].text.toLowerCase();
    const container = document.getElementById('instruksiMetode');

    container.innerHTML = '';
    container.classList.add('hidden');
    if (!selected) return;

    let html = '';

    if (selected.includes('transfer')) {
        html = `
        <div class="bg-white/90 p-6 rounded-2xl border border-emerald-100 shadow-sm">
            <h3 class="text-emerald-700 font-bold text-lg flex items-center gap-2">
                <i class="fas fa-university text-emerald-500"></i> Instruksi Transfer Bank
            </h3>
            <p class="text-gray-700 mt-2">Silakan transfer ke rekening berikut:</p>
            <ul class="list-disc ml-6 text-gray-700 mt-2">
                <li>BCA 123456789 a.n. LAZ Zakat</li>
                <li>Mandiri 987654321 a.n. LAZ Zakat</li>
            </ul>
        </div>
        `;
    } else if (selected.includes('e-wallet')) {
        html = `
        <div class="bg-white/90 p-6 rounded-2xl border border-emerald-100 shadow-sm">
            <h3 class="text-emerald-700 font-bold text-lg flex items-center gap-2">
                <i class="fas fa-mobile-alt text-emerald-500"></i> Instruksi E-Wallet
            </h3>
            <p class="text-gray-700 mt-2">Kirim ke nomor berikut:</p>
            <ul class="list-disc ml-6 text-gray-700 mt-2">
                <li>OVO / GoPay / DANA: 081234567890</li>
            </ul>
        </div>
        `;
    } else if (selected.includes('qris')) {
        html = `
        <div class="bg-white/90 p-6 rounded-2xl border border-emerald-100 shadow-sm text-center">
            <h3 class="text-emerald-700 font-bold text-lg flex items-center justify-center gap-2">
                <i class="fas fa-qrcode text-emerald-500"></i> Scan QRIS
            </h3>
            <p class="text-gray-700 mt-2">Scan QR berikut untuk menyelesaikan pembayaran:</p>
            <img src="/storage/qris.png" alt="QRIS" class="w-48 mx-auto mt-4 rounded-lg shadow-md">
        </div>
        `;
    } else if (selected.includes('tunai')) {
        html = `
        <div class="bg-white/90 p-6 rounded-2xl border border-emerald-100 shadow-sm">
            <h3 class="text-emerald-700 font-bold text-lg flex items-center gap-2">
                <i class="fas fa-money-bill text-emerald-500"></i> Pembayaran Tunai
            </h3>
            <p class="text-gray-700 mt-2">Silakan datang langsung ke kantor LAZ terdekat untuk melakukan pembayaran tunai.</p>
        </div>
        `;
    }

    container.innerHTML = html;
    container.classList.remove('hidden');
}
</script>

<style>
.input-style {
    width: 100%;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.75rem;
    font-size: 1rem;
    color: #374151;
    background-color: #ffffff;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.input-style:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.label {
    display: block;
    font-weight: 600;
    color: #065f46;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}
</style>
@endsection