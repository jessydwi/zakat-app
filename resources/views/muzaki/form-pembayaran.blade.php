@extends('layouts.muzaki')

@section('title', 'Form Pembayaran Zakat')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="bg-gradient-to-br from-green-50 to-emerald-50 p-10 rounded-3xl shadow-md max-w-4xl mx-auto space-y-10 transition hover:shadow-xl animate-fade-in-up">

    <!-- Header -->
    <div class="text-center space-y-2">
        <h2 class="text-3xl font-extrabold text-emerald-700 flex items-center justify-center gap-3">
            <i class="fas fa-hand-holding-dollar text-emerald-500"></i>
            Form Pembayaran Zakat
        </h2>
    </div>

<form action="{{ route('muzaki.transaksi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf

    @php
        $muzakki = auth()->user()->muzakki;
        $user = auth()->user();
    @endphp

    <!-- Nama Lengkap -->
    <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
        <label for="nama" class="block font-semibold text-emerald-700 mb-3 text-lg">
            <i class="fas fa-user text-emerald-500 mr-2"></i> Nama Lengkap
        </label>
        <input type="text" name="nama" id="nama"
            class="input-style"
            value="{{ $muzakki->nama ?? $user->name }}"
            placeholder="Nama lengkap otomatis" readonly required>
    </div>

    <!-- Jenis Kelamin -->
    <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
        <label for="jenis_kelamin" class="block font-semibold text-emerald-700 mb-3 text-lg">
            <i class="fas fa-venus-mars text-emerald-500 mr-2"></i> Jenis Kelamin
        </label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="input-style" readonly required>
            <option value="">-- isi jenis kelamin anda --</option>
            <option value="Laki-laki" {{ (old('jenis_kelamin') ?? ($muzakki->jenis_kelamin ?? '')) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ (old('jenis_kelamin') ?? ($muzakki->jenis_kelamin ?? '')) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    <!-- Alamat -->
    <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
        <label class="block font-semibold text-emerald-700 mb-3 text-lg">
            <i class="fas fa-map-marker-alt text-emerald-500 mr-2"></i> Alamat
        </label>
        <input type="text" class="input-style"
               name="alamat"
               value="{{ $muzakki->alamat ?? '' }}"
               readonly required>
    </div>

    <!-- Pekerjaan -->
    <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
        <label class="block font-semibold text-emerald-700 mb-3 text-lg">
            <i class="fas fa-briefcase text-emerald-500 mr-2"></i> Pekerjaan
        </label>
        <input type="text" class="input-style"
               name="pekerjaan"
               value="{{ $muzakki->pekerjaan ?? '' }}"
               readonly required>
    </div>

    <!-- Kontak -->
    <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
        <label class="block font-semibold text-emerald-700 mb-3 text-lg">
            <i class="fas fa-phone text-emerald-500 mr-2"></i> Nomor HP / Email
        </label>
        <input type="text" class="input-style"
               name="kontak"
               value="{{ $muzakki->kontak ?? $user->email }}"
               readonly required>
    </div>

    <!-- Pilihan Jenis Zakat -->
    <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
        <label class="block font-semibold text-emerald-700 mb-3 text-lg">
            <i class="fas fa-donate text-emerald-500 mr-2"></i> Jenis Dana
        </label>
        <select name="jenis_zakat_id" id="jenis_zakat_id"
                class="input-style text-gray-700 text-base"
                onchange="tampilkanFormKhusus()" required>
            <option value="">-- Pilih Jenis Dana --</option>
            @foreach($jenisZakat as $j)
                <option value="{{ $j->id }}"
                    data-nama="{{ strtolower($j->nama_jenis) }}">
                    {{ $j->nama_jenis }}
                </option>
            @endforeach
        </select>
    </div>

    <div id="formKhusus" class="space-y-4 hidden animate-fade-in-up"></div>

    <!-- Metode Pembayaran -->
    <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
        <label for="metode_id" class="block font-semibold text-emerald-700 mb-3 text-lg">
            <i class="fas fa-credit-card text-emerald-500 mr-2"></i> Metode Pembayaran
        </label>
        <div id="instruksiMetode" class="space-y-4 hidden animate-fade-in-up"></div>
        <select name="metode_id" id="metode_id"
            class="input-style"
            onchange="tampilkanInstruksiMetode()" required>
            <option value="">-- Pilih Metode Pembayaran --</option>
            @foreach($metode as $m)
                <option value="{{ $m->id }}"
                    {{ session('metode_id') == $m->id ? 'selected' : '' }}>
                    {{ $m->nama_metode }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Tanggal -->
    <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
        <label class="block font-semibold text-emerald-700 mb-3 text-lg">
            <i class="fas fa-calendar-alt text-emerald-500 mr-2"></i> Tanggal Transaksi
        </label>
        <input type="date" name="tanggal" id="tanggal"
               class="input-style" required>
    </div>

    <!-- Bukti Pembayaran -->
    <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition">
        <label class="block font-semibold text-emerald-700 mb-3 text-lg">
            <i class="fas fa-file-upload text-emerald-500 mr-2"></i> Bukti Pembayaran
        </label>
        <input type="file" name="bukti_pembayaran"
               class="input-style"
               accept="image/*,application/pdf">
    </div>

    <input type="hidden" id="muzakki_id" name="muzakki_id" value="{{ $muzakki->id ?? '' }}">
    <div class="pt-2">
        <button type="submit"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-lg">
            <i class="fas fa-paper-plane"></i> Simpan Pembayaran
        </button>
    </div>
</form>

    <!-- Pop-up Transfer -->
    <div id="popupTransfer" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-xl w-full max-w-md space-y-4 shadow-lg">
            <h3 class="text-lg font-bold text-emerald-700">Konfirmasi Transfer Zakat</h3>

            <!-- ID Transaksi -->
            <label class="block text-sm font-medium">ID Transaksi</label>
            <input type="text" id="idTransaksi" class="input-style" readonly>

            <!-- Pilih Bank -->
            <label class="block text-sm font-medium mt-2">Pilih Bank</label>
            <select id="bankTujuan" class="input-style" onchange="tampilkanRekening()" required>
                <option value="">-- Pilih Bank --</option>
                <option value="BNI">BNI</option>
                <option value="BCA">BCA</option>
                <option value="BRI">BRI</option>
                <option value="Mandiri">Mandiri</option>
            </select>

            <!-- Nomor Rekening -->
            <label class="block text-sm font-medium mt-2">Nomor Rekening</label>
            <input type="text" id="nomorRekening" class="input-style" readonly>

            <!-- Nominal Transfer -->
            <label class="block text-sm font-medium mt-2">Nominal Transfer</label>
            <input type="number" id="nominalTransfer" class="input-style" placeholder="Contoh: 75000" required>

            <div class="flex justify-end gap-2 mt-4">
                <button onclick="tutupPopupTransfer()" type="button" class="btn-secondary">Batal</button>
                <button onclick="lanjutKeDetailTransfer()" type="button" class="btn-primary">Lanjutkan</button>
            </div>
        </div>
    </div>
</div>

<script>
const muzakkiData = @json($muzakki);

// isiDataMuzakki tidak wajib digunakan (data sudah diisi server-side).
function isiDataMuzakki() {
    const muzakki = muzakkiData || {};
    if (muzakki) {
        document.getElementById('nama').value = muzakki.nama || '';
        document.getElementById('jenis_kelamin').value = muzakki.jenis_kelamin || '';
        document.getElementById('alamat').value = muzakki.alamat || '';
        document.getElementById('pekerjaan').value = muzakki.pekerjaan || '';
        document.getElementById('kontak').value = muzakki.kontak || muzakki.no_hp || '';
    }
}

const nisabHarian = {{ $nisabHarian ?? 15000 }};

function tampilkanFormKhusus() {
    const select = document.getElementById('jenis_zakat_id');
    const selectedOption = select.options[select.selectedIndex];
    const jenis = selectedOption ? selectedOption.dataset.nama : '';
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
                <label class="label"><i class="fas fa-money-bill-wave text-emerald-500 mr-1"></i> Nominal Zakat Maal (opsional jika ingin override)</label>
                <input type="number" name="nominal" class="input-style" placeholder="Masukkan nominal zakat maal">
            </div>
        </div>
        `;
    }

    // ==== Fidyah ====
    else if (jenis.includes('fidyah')) {
        html = `
        <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition space-y-4">
            <h3 class="text-emerald-700 font-bold text-lg flex items-center gap-2">
                <i class="fas fa-bread-slice text-emerald-500"></i> Detail Zakat Fidyah
            </h3>
            <div>
                <label class="label"><i class="fas fa-calendar-day text-emerald-500 mr-1"></i> Jumlah Hari</label>
                <input type="number" name="jumlah_hari" id="jumlah_hari" class="input-style" placeholder="Masukkan jumlah hari" required>
            </div>
            <div>
                <label class="label">Nisab Harian (otomatis)</label>
                <input type="number" name="nisab_harian" id="nisab_harian" class="input-style" value="${nisabHarian}" readonly>
            </div>
            <div>
                <label class="label"><i class="fas fa-money-bill-wave text-emerald-500 mr-1"></i> Nominal Total Fidyah</label>
                <input type="text" name="nominal" id="total_fidyah" class="input-style" placeholder="Nominal total fidyah otomatis" readonly required>
            </div>
        </div>
        `;

        setTimeout(() => {
            const jumlahHariInput = document.getElementById('jumlah_hari');
            const nominalPerHariInput = document.getElementById('nisab_harian');
            const totalFidyahInput = document.getElementById('total_fidyah');

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(angka);
            }

            function hitungTotalFidyah() {
                const hari = parseInt(jumlahHariInput.value);
                const perHari = parseInt(nominalPerHariInput.value) || 0;

                const totalHari = isNaN(hari) || hari < 1 ? 1 : hari;
                const total = totalHari * perHari;
                totalFidyahInput.value = formatRupiah(total);
            }

            jumlahHariInput.addEventListener('input', hitungTotalFidyah);
            hitungTotalFidyah();
        }, 50);
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
            <button type="button" onclick="bukaPopupTransfer()" 
                class="mt-4 bg-emerald-600 text-white px-4 py-2 rounded-lg shadow hover:bg-emerald-700">
                Konfirmasi Transfer
            </button>
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

function bukaPopupTransfer() {
    // Generate ID transaksi otomatis
    const id = 'TRX' + new Date().toISOString().replace(/[-:.TZ]/g, '').slice(0, 14);
    document.getElementById('idTransaksi').value = id;
    document.getElementById('popupTransfer').classList.remove('hidden');
}

function tutupPopupTransfer() {
    document.getElementById('popupTransfer').classList.add('hidden');
}

function tampilkanRekening() {
    const bank = document.getElementById('bankTujuan').value;
    let rekening = '';

    switch(bank) {
        case 'BNI':
            rekening = 'BNI 1122334455 a.n. LAZ Zakat';
            break;
        case 'BCA':
            rekening = 'BCA 123456789 a.n. LAZ Zakat';
            break;
        case 'BRI':
            rekening = 'BRI 9988776655 a.n. LAZ Zakat';
            break;
        case 'Mandiri':
            rekening = 'Mandiri 987654321 a.n. LAZ Zakat';
            break;
    }

    document.getElementById('nomorRekening').value = rekening;
}

function lanjutKeDetailTransfer() {
    const id           = document.getElementById('idTransaksi').value;
    const nominal      = document.getElementById('nominalTransfer').value;
    const bank         = document.getElementById('bankTujuan').value;
    const rekening     = document.getElementById('nomorRekening').value;

    // Data Muzakki
    const muzakkiId    = document.getElementById('muzakki_id').value;
    const namaLengkap  = document.getElementById('nama').value;
    const jenisKelamin = document.getElementById('jenis_kelamin').value;
    const alamat       = document.getElementById('alamat').value;
    const pekerjaan    = document.getElementById('pekerjaan').value;
    const kontak       = document.getElementById('kontak').value;
    const jenisZakatId = document.getElementById('jenis_zakat_id').value;
    const metodeId     = document.getElementById('metode_id').value;
    const tanggal      = document.getElementById('tanggal').value;

    // Validasi
    if (!bank || !rekening || !id || !nominal || nominal < 1000) {
        alert('Lengkapi semua data. Nominal minimal Rp1.000.');
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/muzaki/transaksi/store';

    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    form.innerHTML = `
        <input type="hidden" name="_token" value="${csrf}">
        <input type="hidden" name="idTransaksi" value="${id}">
        <input type="hidden" name="nominalTransfer" value="${nominal}">
        <input type="hidden" name="bankTujuan" value="${bank}">
        <input type="hidden" name="nomorRekening" value="${rekening}">
        <input type="hidden" name="muzakki_id" value="${muzakkiId}">
        <input type="hidden" name="nama_lengkap" value="${namaLengkap}">
        <input type="hidden" name="jenis_kelamin" value="${jenisKelamin}">
        <input type="hidden" name="alamat" value="${alamat}">
        <input type="hidden" name="pekerjaan" value="${pekerjaan}">
        <input type="hidden" name="kontak" value="${kontak}">
        <input type="hidden" name="jenis_zakat_id" value="${jenisZakatId}">
        <input type="hidden" name="metode_id" value="${metodeId}">
        <input type="hidden" name="tanggal" value="${tanggal}">
    `;

    document.body.appendChild(form);
    form.submit();
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
