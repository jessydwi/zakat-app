@extends('layouts.admin')

@section('content')

<h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
    <i class="fas fa-bell text-emerald-600 mr-2"></i> Daftar Notifikasi
</h2>

<ul class="space-y-3">
    @forelse($notifikasi as $notif)
        <li class="p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 flex items-start justify-between">
            <div class="flex items-start space-x-3">
                <!-- Icon -->
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full 
                        {{ $notif->status_baca ? 'bg-gray-200 text-gray-500' : 'bg-emerald-100 text-emerald-600' }}">
                        <i class="fas fa-bell"></i>
                    </div>
                </div>

                <!-- Content -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">
                        {{ $notif->judul }}
                    </h3>
                    <a href="{{ route('admin.notifikasi.show', $notif->id) }}" 
                       class="text-sm text-gray-600 mt-1 hover:text-emerald-600 transition">
                        {{ $notif->pesan }}
                    </a>
                    <span class="text-xs text-gray-400 mt-2 block">
                        {{ $notif->tanggal ? \Carbon\Carbon::parse($notif->tanggal)->diffForHumans() : '' }}
                    </span>
                </div>
            </div>

            <!-- Status / Action -->
            @if(!$notif->status_baca)
                <form method="POST" action="{{ route('admin.notifikasi.baca', $notif->id) }}">
                    @csrf
                    <button class="text-xs font-medium text-blue-600 hover:text-blue-800">
                        Tandai dibaca
                    </button>
                </form>
            @else
                <span class="text-xs text-gray-400 italic">Sudah dibaca</span>
            @endif
        </li>
    @empty
        <li class="p-4 bg-gray-50 rounded-lg text-center text-gray-500">
            Tidak ada notifikasi
        </li>
    @endforelse
</ul>
@endsection
