@props([
    'title',
    'value',
    'icon' => 'fas fa-chart-bar',
    'color' => 'emerald',
    'subtitle' => null
])

<div class="bg-white shadow rounded-xl p-6 flex items-center gap-4 border-l-4 border-{{ $color }}-500">
    <div class="text-3xl text-{{ $color }}-500">
        <i class="{{ $icon }}"></i>
    </div>
    <div>
        <h3 class="text-sm font-semibold text-gray-500">{{ $title }}</h3>
        <p class="text-2xl font-bold text-gray-800">
            @if(is_numeric($value))
                Rp {{ number_format($value, 0, ',', '.') }}
            @else
                {{ $value }}
            @endif
        </p>
        @if($subtitle)
            <p class="text-sm text-gray-500">{{ $subtitle }}</p>
        @endif
    </div>
</div>
