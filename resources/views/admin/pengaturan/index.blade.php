@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-8 space-y-8">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-emerald-700">Pengaturan Umum Website Zakat</h1>
            <p class="text-sm text-gray-500">Kelola informasi lembaga, branding, notifikasi, dan ketentuan zakat</p>
        </div>
        <div class="flex gap-4">
            @if(request('edit'))
                <a href="{{ route('admin.pengaturan.index') }}" class="text-sm text-gray-600 hover:text-emerald-600 hover:underline">
                    ← Batal Edit
                </a>
            @else
                <a href="{{ route('admin.pengaturan.index', ['edit' => 'true']) }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
                    ✏️ Edit Pengaturan
                </a>
                 <a href="{{ route('admin.ketentuan.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    ⚙️ Kelola Ketentuan Zakat
                </a>
            @endif
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-800 px-4 py-2 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(request('edit'))
        {{-- Form Edit --}}
        <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @include('admin.pengaturan.form', ['setting' => $setting, 'data' => $data])

            <div class="text-right">
                <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-lg shadow hover:bg-emerald-700 transition">
                    💾 Simpan Pengaturan
                </button>
            </div>
        </form>
    @else
        {{-- Tampilan Read-Only --}}
        <div class="space-y-6">
            @include('admin.pengaturan.readonly', ['setting' => $setting, 'data' => $data])
        </div>
    @endif
</div>
@endsection
