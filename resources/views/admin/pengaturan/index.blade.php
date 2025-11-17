@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-10 space-y-10">

    {{-- Header dengan latar hijau --}}
    <div class="bg-emerald-600 rounded-2xl p-6 flex flex-col sm:flex-row justify-between items-center text-white shadow-md">
        <div>
            <h1 class="text-3xl font-bold">Pengaturan Umum Website Zakat</h1>
            <p class="text-emerald-200 mt-1 max-w-xl">Kelola informasi lembaga, branding, notifikasi, dan ketentuan zakat dengan mudah dan profesional.</p>
        </div>
        <div class="flex gap-4 mt-4 sm:mt-0">
            @if(request('edit'))
                <a href="{{ route('admin.pengaturan.index') }}" 
                    class="bg-emerald-200 text-emerald-800 px-5 py-2 rounded-lg hover:bg-emerald-300 transition shadow-md flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    ← Batal Edit
                </a>
            @else
                <a href="{{ route('admin.pengaturan.index', ['edit' => 'true']) }}" 
                    class="bg-white text-emerald-600 px-5 py-2 rounded-lg shadow font-semibold hover:bg-gray-100 transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Pengaturan
                </a>
                <a href="{{ route('admin.ketentuan.index') }}" 
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 shadow transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 12v.01M16.24 7.76a6 6 0 11-8.48 8.48 6 6 0 018.48-8.48z" />
                    </svg>
                    Kelola Ketentuan Zakat
                </a>
            @endif
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-6 py-3 rounded-lg shadow-md">
            {{ session('success') }}
        </div>
    @endif

    @if(request('edit'))
        {{-- Form Edit dengan bayangan dan rounded besar --}}
        <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" class="space-y-10 bg-gray-50 p-8 rounded-xl shadow-inner">
            @csrf

            {{-- Sertakan form input --}}
            @include('admin.pengaturan.form', ['setting' => $setting, 'data' => $data])

            <div class="text-right">
                <a href="{{ route('admin.pengaturan.index') }}"
                    class="bg-emerald-600 text-white px-10 py-3 rounded-lg shadow hover:bg-emerald-700 transition font-semibold tracking-wide flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Pengaturan
                </a>
            </div>
        </form>
    @else
        {{-- Read-only view dengan style card seperti contoh --}}
        <div class="space-y-10 bg-white rounded-xl border border-gray-200 p-8 shadow-lg">
            @include('admin.pengaturan.readonly', ['setting' => $setting, 'data' => $data])
        </div>
    @endif
</div>
@endsection