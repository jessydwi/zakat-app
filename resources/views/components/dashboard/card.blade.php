<div class="group bg-gradient-to-br from-green-50 to-white rounded-2xl border border-green-100 p-6 shadow-sm hover:shadow-lg transition-all duration-300 {{ $class ?? '' }}">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">{{ $title }}</p>
            <h3 class="text-3xl font-extrabold text-green-700 mt-1">
                Rp {{ $value }}
            </h3>
        </div>
        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-green-100 group-hover:bg-green-200 transition">
            <i class="fas {{ $icon }} text-green-600 text-2xl"></i>
        </div>
    </div>
</div>
