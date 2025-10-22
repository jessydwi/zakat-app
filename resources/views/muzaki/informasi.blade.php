@extends('layouts.muzaki')

@section('title', 'Informasi & Edukasi Zakat')

@section('content')
    <div class="max-w-6xl mx-auto bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-8 space-y-10 border border-emerald-100 animate-fade-in-up">

        <!-- Header -->
        <div class="border-b border-emerald-100 pb-4 mb-6">
            <h2 class="text-3xl font-bold text-emerald-800 flex items-center gap-2">
                📚 Informasi & Edukasi Zakat
            </h2>
            <p class="text-gray-600 mt-2 leading-relaxed">
                Pelajari segala hal tentang zakat, panduan menghitungnya, hingga video edukatif dan tanya jawab umum.
            </p>
        </div>

        <!-- Artikel Hukum Zakat -->
        <section class="bg-emerald-50/70 p-6 rounded-xl border border-emerald-100 shadow-sm hover:shadow-md transition">
            <h3 class="text-xl font-semibold text-emerald-800 mb-3">📘 Artikel Tentang Hukum Zakat</h3>
            <p class="text-gray-700 leading-relaxed mb-4">
                Zakat merupakan kewajiban bagi setiap muslim yang mampu, sebagaimana disebutkan dalam Al-Qur'an:
                <em>“Ambillah zakat dari sebagian harta mereka, dengan zakat itu kamu membersihkan dan mensucikan mereka...”</em>
                (QS. At-Taubah: 103). Jenis zakat meliputi zakat fitrah, zakat mal, zakat penghasilan, zakat pertanian,
                dan zakat emas/perak. Dana zakat diberikan kepada mustahik seperti fakir, miskin, dan golongan lainnya.
            </p>
            <a href="https://baznas.go.id/artikel" target="_blank"
               class="inline-flex items-center text-emerald-700 font-medium hover:text-emerald-900 transition underline-offset-2 hover:underline">
                🌐 Baca selengkapnya di situs resmi BAZNAS
            </a>
        </section>

        <!-- Panduan Menghitung Zakat -->
        <section class="bg-emerald-50/70 p-6 rounded-xl border border-emerald-100 shadow-sm hover:shadow-md transition">
            <h3 class="text-xl font-semibold text-emerald-800 mb-3">📐 Panduan Menghitung Zakat</h3>
            <ul class="list-disc pl-6 text-gray-700 space-y-2">
                <li><strong>Zakat Mal:</strong> 2.5% dari total harta setelah mencapai nisab.</li>
                <li><strong>Zakat Penghasilan:</strong> 2.5% dari gaji bulanan yang sudah mencapai nisab.</li>
                <li><strong>Zakat Pertanian:</strong> 5%–10% tergantung metode irigasi.</li>
                <li><strong>Zakat Emas/Perak:</strong> jika mencapai nisab (≥ 85 gram emas).</li>
            </ul>
            <a href="{{ route('muzaki.kalkulator') }}"
               class="mt-4 inline-block bg-emerald-600 text-white px-5 py-3 rounded-lg hover:bg-emerald-700 transition font-semibold shadow-sm">
                🧮 Coba Kalkulator Zakat
            </a>
        </section>

        <!-- Video Edukasi -->
        <section class="bg-emerald-50/70 p-6 rounded-xl border border-emerald-100 shadow-sm hover:shadow-md transition">
            <h3 class="text-xl font-semibold text-emerald-800 mb-3">🎥 Video Edukasi Zakat</h3>
            <p class="text-gray-700 mb-4">
                Tonton video edukatif dari BAZNAS dan lembaga zakat lainnya untuk memahami zakat secara visual dan mudah.
            </p>
            <div class="space-y-3">
                <a href="https://www.youtube.com/watch?v=ns8MVNT_XrU" target="_blank"
                   class="block text-emerald-700 hover:text-emerald-900 font-medium transition underline-offset-2 hover:underline">
                    ▶️ Bermain Sambil Belajar – BAZNAS Edukasi Anak
                </a>
                <a href="https://www.youtube.com/watch?v=mDL3EzBjVY0" target="_blank"
                   class="block text-emerald-700 hover:text-emerald-900 font-medium transition underline-offset-2 hover:underline">
                    ▶️ Edukasi Cinta Zakat untuk Siswa SD
                </a>
                <a href="https://www.youtube.com/watch?v=eFv-uxJk5Gk" target="_blank"
                   class="block text-emerald-700 hover:text-emerald-900 font-medium transition underline-offset-2 hover:underline">
                    ▶️ Tutorial Zakat Fitri – Akusuka
                </a>
            </div>
        </section>

        <!-- FAQ Zakat -->
        <section class="bg-emerald-50/70 p-6 rounded-xl border border-emerald-100 shadow-sm hover:shadow-md transition">
            <h3 class="text-xl font-semibold text-emerald-800 mb-3">❓ Tanya Jawab Seputar Zakat (FAQ)</h3>
            <div class="space-y-4">
                <details class="bg-white/90 border border-emerald-100 rounded-lg p-4 shadow-sm hover:shadow transition">
                    <summary class="cursor-pointer font-semibold text-gray-800">Apa bedanya zakat dan sedekah?</summary>
                    <p class="mt-2 text-gray-600 leading-relaxed">
                        Zakat adalah kewajiban dengan syarat nisab dan haul, sedangkan sedekah bersifat sukarela tanpa batasan jumlah maupun waktu.
                    </p>
                </details>

                <details class="bg-white/90 border border-emerald-100 rounded-lg p-4 shadow-sm hover:shadow transition">
                    <summary class="cursor-pointer font-semibold text-gray-800">Apakah zakat bisa dibayar secara online?</summary>
                    <p class="mt-2 text-gray-600 leading-relaxed">
                        Ya, kini banyak lembaga resmi seperti BAZNAS, Dompet Dhuafa, dan lainnya menyediakan layanan zakat online dengan sistem yang aman dan transparan.
                    </p>
                </details>

                <details class="bg-white/90 border border-emerald-100 rounded-lg p-4 shadow-sm hover:shadow transition">
                    <summary class="cursor-pointer font-semibold text-gray-800">Bagaimana cara menghitung nisab zakat?</summary>
                    <p class="mt-2 text-gray-600 leading-relaxed">
                        Nisab zakat mal setara dengan 85 gram emas. Jika nilai harta kamu melebihi jumlah tersebut, maka kamu wajib menunaikan zakat sebesar 2.5%.
                    </p>
                </details>
            </div>
        </section>

    </div>

<!-- Animasi lembut -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
</style>
@endsection
