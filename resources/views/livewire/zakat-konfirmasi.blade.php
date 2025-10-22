<table class="w-full table-auto text-sm text-left">
    <thead class="bg-yellow-100 text-yellow-700 font-semibold">
        <tr>
            <th class="px-4 py-2">Nama Muzakki</th>
            <th class="px-4 py-2">Nominal</th>
            <th class="px-4 py-2">Tanggal</th>
            <th class="px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pending as $item)
        <tr class="border-b">
            <td class="px-4 py-2">{{ $item->muzakki->nama ?? '-' }}</td>
            <td class="px-4 py-2">Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
            <td class="px-4 py-2">
                <button wire:click="konfirmasi({{ $item->id }})"
                    class="px-3 py-1 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition">
                    Konfirmasi
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="px-4 py-2 text-center text-gray-500">Tidak ada transaksi menunggu.</td>
        </tr>
        @endforelse
    </tbody>
</table>
