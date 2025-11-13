<div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-shadow duration-300">
    <div class="flex items-center gap-3 mb-6">
        <i class="fas fa-check-circle text-yellow-600 text-2xl"></i>
        <h2 class="text-lg font-semibold text-yellow-800">Konfirmasi Transaksi</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full table-auto text-sm text-left border-collapse">
            <thead class="bg-yellow-100 text-yellow-700 font-semibold rounded-t-lg">
                <tr>
                    <th class="px-4 py-3 rounded-tl-lg">Nama Muzakki</th>
                    <th class="px-4 py-3">Nominal</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3 rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pending as $item)
                <tr class="border-b border-gray-200 hover:bg-yellow-50 transition-colors duration-200">
                    <td class="px-4 py-3 text-gray-700">{{ $item->muzakki->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-700 font-medium">Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <button wire:click="konfirmasi({{ $item->id }})"
                                class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-all duration-300 transform hover:scale-105 shadow-md flex items-center gap-2">
                            <i class="fas fa-check"></i> Konfirmasi
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl text-gray-400 mb-2"></i>
                        <p>Tidak ada transaksi menunggu.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
