@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-xl font-bold text-emerald-800 mb-4 flex items-center">
        <i class="fas fa-bell text-emerald-600 mr-2"></i> Detail Notifikasi
    </h2>

    <div class="space-y-3">
        <p><strong>Judul:</strong> {{ $notif->judul }}</p>
        <p><strong>Pesan:</strong> {{ $notif->pesan }}</p>
        <p><strong>Tanggal:</strong> {{ $notif->tanggal ? \Carbon\Carbon::parse($notif->tanggal)->format('d M Y H:i') : '-' }}</p>
        <p><strong>Status:</strong> {{ $notif->status_baca ? 'Sudah dibaca' : 'Belum dibaca' }}</p>
    </div>

    {{-- ✅ Data Pengirim Pesan --}}
    @if($notif->pengirim)
    <div class="mt-6 border-t pt-4">
        <h3 class="text-lg font-semibold text-emerald-700 mb-3">Data Pengirim Pesan</h3>
        <p><strong>Nama:</strong> {{ $notif->pengirim->nama }}</p>
        <p><strong>Email:</strong> {{ $notif->pengirim->email }}</p>
        <p><strong>No HP:</strong> {{ $notif->pengirim->no_hp ?? '-' }}</p>
        <p><strong>Role:</strong> {{ ucfirst($notif->pengirim->role) }}</p>
    </div>
    @endif

    {{-- Jika notifikasi terkait muzakki --}}
    @if($notif->muzakki)
    <div class="mt-6 border-t pt-4">
        <h3 class="text-lg font-semibold text-emerald-700 mb-3">Data Muzakki</h3>
        <p><strong>Nama:</strong> {{ $notif->muzakki->nama }}</p>
        <p><strong>No HP:</strong> {{ $notif->muzakki->no_hp }}</p>
        <p><strong>Email:</strong> {{ $notif->muzakki->email ?? '-' }}</p>
    </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.notifikasi.index') }}" 
           class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded transition">
            ← Kembali
        </a>
    </div>
</div>
@endsection
