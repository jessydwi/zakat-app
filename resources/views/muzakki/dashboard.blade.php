<x-layout.muzakki>
    <div class="space-y-6">

        {{-- Penjelasan Zakat --}}
        <x-card title="Tentang Zakat, Infak, dan Sedekah">
            <p class="text-gray-700 leading-relaxed">
                <strong>Zakat</strong> adalah kewajiban harta bagi umat Islam yang mampu. <strong>Infak</strong> adalah sumbangan sukarela. <strong>Sedekah</strong> adalah segala bentuk kebaikan.
            </p>
        </x-card>

        {{-- Keutamaan Zakat --}}
        <x-card title="Keutamaan Zakat">
            <ul class="list-disc pl-5 text-gray-700">
                <li>Menyucikan jiwa dan harta</li>
                <li>Menumbuhkan solidaritas sosial</li>
                <li>Menolong fakir miskin</li>
                <li>Menjaga keberkahan harta</li>
            </ul>
        </x-card>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-stat-card title="Total Zakat Terkumpul" :value="number_format($totalZakat, 0, ',', '.') . ' IDR'" icon="💰" />
            <x-stat-card title="Penerima Manfaat" :value="$totalPenerima . ' Orang'" icon="🧑‍🤝‍🧑" />
        </div>

        {{-- Tombol Bayar --}}
        <div class="text-center">
            <a href="{{ route('muzakki.bayar') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                Bayar Zakat Sekarang
            </a>
        </div>

    </div>
</x-layout.muzakki>
