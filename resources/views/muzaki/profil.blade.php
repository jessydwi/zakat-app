@extends('layouts.muzaki')
@section('title', 'Profil Saya')

@section('content')

<div class="max-w-4xl mx-auto bg-white p-10 rounded-2xl shadow-lg space-y-8">

    <!-- Header -->
    <div class="flex items-center gap-3 border-b pb-4">
        <div class="bg-emerald-600 text-white p-3 rounded-xl">
            <i class="fas fa-user text-xl"></i>
        </div>
        <h2 class="text-3xl font-bold text-emerald-700">
            Pengaturan Profil Muzaki
        </h2>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-700 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Edit / Simpan -->
    <div class="flex justify-end">
        <button id="btnEdit"
            type="button"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl shadow">
            <i class="fas fa-edit mr-1"></i> Edit Profil
        </button>

        <button id="btnSimpan"
            style="display:none;"
            class="bg-emerald-600 hover:bg-emerald-700 ml-3 text-white px-5 py-2 rounded-xl shadow">
            <i class="fas fa-save mr-1"></i> Simpan Perubahan
        </button>
    </div>

    <form id="formProfil" action="{{ route('muzaki.profil.update') }}" method="POST">
        @csrf

        <!-- Informasi Akun -->
        <div class="bg-gray-50 p-6 rounded-xl border space-y-4">
            <h3 class="text-xl font-semibold text-emerald-700 border-l-4 border-emerald-600 pl-3">
                Informasi Akun
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Akun</label>
                    <input type="email" name="email"
                        value="{{ $user->email }}"
                        class="input-field"
                        readonly>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama"
                        value="{{ $muzakki->nama }}"
                        class="input-field"
                        readonly>
                </div>

            </div>
        </div>

        <!-- Data Muzakki -->
        <div class="bg-gray-50 p-6 rounded-xl border space-y-4">
            <h3 class="text-xl font-semibold text-emerald-700 border-l-4 border-emerald-600 pl-3">
                Data Muzakki
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Muzakki</label>
                    <input type="email" name="email_muzakki"
                        value="{{ $muzakki->email }}"
                        class="input-field"
                        readonly>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor HP</label>
                    <input type="text" name="no_hp"
                        value="{{ $muzakki->no_hp }}"
                        class="input-field"
                        readonly>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan"
                        value="{{ $muzakki->pekerjaan }}"
                        class="input-field"
                        readonly>
                </div>

                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label>
                    <input type="text" name="alamat"
                        value="{{ $muzakki->alamat }}"
                        class="input-field"
                        readonly>
                </div>

            </div>
        </div>

        <!-- Submit hide (karena tombol simpan di luar form) -->
        <button id="realSubmit" type="submit" style="display:none;"></button>

    </form>

</div>

<!-- Script -->
<script>
    const btnEdit = document.getElementById('btnEdit');
    const btnSimpan = document.getElementById('btnSimpan');
    const form = document.getElementById('formProfil');
    const realSubmit = document.getElementById('realSubmit');
    const fields = document.querySelectorAll('.input-field');

    btnEdit.addEventListener('click', () => {
        fields.forEach(f => f.removeAttribute('readonly'));

        btnEdit.style.display = "none";
        btnSimpan.style.display = "inline-block";
    });

    btnSimpan.addEventListener('click', () => {
        realSubmit.click();
    });
</script>

<style>
    .input-field {
        @apply w-full px-4 py-2 rounded-lg border bg-gray-100 focus:bg-white focus:ring-2 focus:ring-emerald-500;
    }
    .input-field[readonly] {
        @apply cursor-not-allowed bg-gray-100;
    }
</style>

@endsection
