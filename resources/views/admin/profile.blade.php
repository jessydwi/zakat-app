@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto mt-10">

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg p-6 border">
        <h2 class="text-2xl font-bold text-emerald-700 mb-4">Profil Admin</h2>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none">
                @error('email') 
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Password Baru -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Password Baru</label>
                <input type="password" name="password"
                       placeholder="Biarkan kosong jika tidak ingin mengubah"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none">
                @error('password') 
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg font-medium transition">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
