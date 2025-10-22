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
