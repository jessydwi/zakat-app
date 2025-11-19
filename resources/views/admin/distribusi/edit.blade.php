@extends('layouts.admin')

@section('title', 'Edit Distribusi Zakat')

@section('content') 
@php $slug = $slug ?? optional(App\Models\JenisBantuan::find(old('jenis_bantuan_id', $distribusi->jenis_bantuan_id)))->slug; 
$detail = is_array($distribusi->detail_json) ? $distribusi->detail_json : json_decode($distribusi->detail_json, true); @endphp

<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-100 py-12 px-4 sm:px-6 lg:px-8"> 
    <div class="max-w-4xl mx-auto"> <div class="bg-white rounded-3xl shadow-2xl p-10 hover:shadow-3xl transition-all duration-500 border border-emerald-100"> 
        {{-- Header Form --}} 
        <div class="text-center mb-10"> <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 rounded-full mb-4"> 
            <i class="fas fa-edit text-emerald-600 text-3xl"></i> 
        </div> <h2 class="text-3xl font-extrabold text-emerald-800 tracking-tight">Edit Distribusi Zakat</h2>
         <p class="text-gray-600 mt-2">Perbarui informasi distribusi zakat dengan mudah dan akurat.</p> </div>

            <form method="POST" action="{{ route('admin.distribusi.update', $distribusi->id) }}" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Grid Layout for Fields --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Mustahik --}}
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-user text-emerald-600"></i> Mustahik
                    </label>
                    <div class="relative">
                        <select name="mustahik_id" class="w-full border border-gray-300 rounded-xl px-4 py-4 focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md appearance-none">
                            <option value="">-- Pilih Mustahik --</option>
                            @foreach($mustahiks as $m)
                                <option value="{{ $m->id }}" {{ old('mustahik_id', $distribusi->mustahik_id) == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('mustahik_id') 
                        <span class="text-sm text-red-600 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                        </span> 
                    @enderror
                </div>

                {{-- Jenis Bantuan --}}
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-hand-holding-heart text-emerald-600"></i> Jenis Bantuan
                    </label>
                    <div class="relative">
                        <select name="jenis_bantuan_id" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-xl px-4 py-4 focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md appearance-none">
                            <option value="">-- Pilih Bantuan --</option>
                            @foreach($jenisBantuans as $b)
                                <option value="{{ $b->id }}" {{ old('jenis_bantuan_id', $distribusi->jenis_bantuan_id) == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama_bantuan }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('jenis_bantuan_id') 
                        <span class="text-sm text-red-600 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                        </span> 
                    @enderror
                </div>

                {{-- Jumlah --}}
                @unless(in_array($slug, ['uang-tunai', 'beasiswa']))
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-calculator text-emerald-600"></i> Jumlah
                        </label>
                        <input type="number" name="jumlah" value="{{ old('jumlah', $distribusi->jumlah) }}" class="w-full border border-gray-300 rounded-xl px-4 py-4 focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md" placeholder="Masukkan jumlah" />
                        @error('jumlah') 
                            <span class="text-sm text-red-600 mt-2 flex items-center gap-1">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </span> 
                        @enderror
                    </div>
                @endunless

                {{-- Tanggal --}}
                <div class="{{ in_array($slug, ['uang-tunai', 'beasiswa']) ? 'md:col-span-2' : 'md:col-span-1' }}">
                    <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-emerald-600"></i> Tanggal
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $distribusi->tanggal) }}" class="w-full border border-gray-300 rounded-xl px-4 py-4 focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md" />
                    @error('tanggal') 
                        <span class="text-sm text-red-600 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                        </span> 
                    @enderror
                </div>
            </div>

            {{-- Detail Modular --}}
            @if($slug)
                <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 p-6 rounded-2xl border-l-4 border-emerald-500 shadow-inner">
                    <h3 class="text-lg font-semibold text-emerald-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-emerald-600"></i> Detail Bantuan
                    </h3>
                    @includeIf('admin.distribusi.detail-form.' . $slug, ['detail' => $detail])
                </div>
            @endif

            {{-- Tombol Submit --}}
            <div class="pt-6 flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-8 py-4 rounded-2xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-xl flex items-center gap-3 font-semibold">
                    <i class="fas fa-save"></i> Update Distribusi
                </button>
            </div>
        </form>
    </div>
</div>
</div>

@endsection