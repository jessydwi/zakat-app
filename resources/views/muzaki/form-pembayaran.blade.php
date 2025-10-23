@extends('layouts.muzaki')

@section('title', 'Form Pembayaran Zakat')

@section('content')
<div class="bg-gradient-to-br from-green-50 to-emerald-50 p-10 rounded-3xl shadow-md max-w-4xl mx-auto space-y-10 transition hover:shadow-xl animate-fade-in-up">

    <!-- Header -->
    <div class="text-center space-y-2">
        <h2 class="text-3xl font-extrabold text-emerald-700 flex items-center justify-center gap-3">
            <i class="fas fa-hand-holding-dollar text-emerald-500"></i>
            Form Pembayaran Zakat
        </h2>
        <p class="text-emerald-600 text-lg font-medium">Lengkapi data berikut untuk menunaikan zakat, infak, atau sedekah Anda.</p>
    </div>

    <!-- Form -->
    <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- Pilihan Jenis Zakat -->
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
            <label for="jenis_zakat_id" class="block font-semibold text-emerald-700 mb-3 text-lg">
                <i class="fas fa-donate text-emerald-500 mr-2"></i> Jenis Dana
            </label>
            <select name="jenis_zakat_id" id="jenis_zakat_id"
                class="input-style text-gray-700 text-base"
                onchange="tampilkanFormKhusus()" required>
                <option value="">-- Pilih Jenis Dana --</option>
                @foreach($jenisZakat as $jenis)
                    <option value="{{ $jenis->id }}" data-nama="{{ strtolower($jenis->nama_jenis) }}">
                        {{ $jenis->nama_jenis }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Form Khusus Berdasarkan Jenis -->
        <div id="formKhusus" class="space-y-4 hidden animate-fade-in-up"></div>

        <!-- Kontak -->
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
            <label for="kontak" class="block font-semibold text-emerald-700 mb-3 text-lg">
                <i class="fas fa-phone text-emerald-500 mr-2"></i> Nomor HP / Email
            </label>
            <input type="text" name="kontak" id="kontak"
                class="input-style"
                placeholder="Contoh: 081234567890 atau email@domain.com" required>
        </div>

<!-- Hidden Muzakki ID -->
<input type="hidden" name="muzakki_id" value="{{ auth()->id() }}">


        <!-- Tombol Submit -->
        <div class="pt-2">
            <button type="submit"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg">
                <i class="fas fa-paper-plane"></i> Bayar Sekarang
            </button>
        </div>
    </form>
</div>

<!-- Animasi dan Style -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }

    .input-style {
        @apply w-full rounded-xl border border-emerald-200 bg-white/70 backdrop-blur-sm px-4 py-3 focus:bg-white focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 shadow-sm transition;
    }

    .label {
        @apply bg-green-600 text-white shadow-lg scale-105;
    }
</style>

<!-- Script Dinamis -->
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
                <input type="number" name="nominal" class="input-style" placeholder="Masukkan nominal per hari" required>
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
                <input type="number" name="nominal" class="input-style" placeholder="Masukkan nominal sedekah" required>
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
</script>
@endsection
