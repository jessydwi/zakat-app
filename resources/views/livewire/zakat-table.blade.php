<div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-shadow duration-300">
    <div class="flex items-center gap-3 mb-6">
        <i class="fas fa-list-ul text-emerald-600 text-2xl"></i>
        <h2 class="text-lg font-semibold text-emerald-800">Daftar Transaksi Zakat</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full table-auto text-sm text-left border-collapse">
            <thead class="bg-emerald-100 text-emerald-700 font-semibold rounded-t-lg">
                <tr>
                    <th class="px-4 py-3 rounded-tl-lg">Nama Muzakki</th>
                    <th class="px-4 py-3">Jenis Zakat</th>
                    <th class="px-4 py-3">Nominal</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3 rounded-tr-lg">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $item)
                <tr class="border-b border-gray-200 hover:bg-emerald-50 transition-colors duration-200">
                    <td class="px-4 py-3 text-gray-700">{{ $item->muzakki->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $item->jenisZakat->nama_jenis ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-700 font-medium">Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1
                            {{ $item->status === 'terbayar' ? 'bg-emerald-100 text-emerald-700' : 'bg-yellow-100 text-yellow-700' }}">
                            <i class="fas {{ $item->status === 'terbayar' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl text-gray-400 mb-2"></i>
                        <p>Belum ada transaksi zakat.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
