@props(['title', 'value', 'icon' => 'fas fa-chart-bar', 'color' => 'emerald'])

<div class="bg-white shadow rounded-xl p-6 flex items-center gap-4 border-l-4 border-{{ $color }}-500">
    <div class="text-3xl text-{{ $color }}-500">
        <i class="{{ $icon }}"></i>
    </div>
    <div>
        <h3 class="text-sm font-semibold text-gray-500">{{ $title }}</h3>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($value, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-gradient-to-br from-green-50 to-white rounded-2xl shadow-sm border-l-4 border-green-500 p-6 hover:shadow-lg transition-all duration-300">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-green-700">{{ $title }}</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">
                Rp {{ number_format($value, 0, ',', '.') }}
            </p>
        </div>
        <div class="w-12 h-12 bg-green-100 flex items-center justify-center rounded-full">
            <i class="fas {{ $icon }} text-green-600 text-xl"></i>
        </div>
    </div>
</div>
