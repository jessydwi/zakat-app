<table class="w-full table-auto text-sm text-left">
    <thead class="bg-emerald-100 text-emerald-700 font-semibold">
        <tr>
            <th class="px-4 py-2">Nama Muzakki</th>
            <th class="px-4 py-2">Jenis Zakat</th>
            <th class="px-4 py-2">Nominal</th>
            <th class="px-4 py-2">Tanggal</th>
            <th class="px-4 py-2">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transaksi as $item)
        <tr class="border-b">
            <td class="px-4 py-2">{{ $item->muzakki->nama ?? '-' }}</td>
            <td class="px-4 py-2">{{ $item->jenisZakat->nama_jenis ?? '-' }}</td>
            <td class="px-4 py-2">Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
            <td class="px-4 py-2">
                <span class="px-2 py-1 rounded-full text-xs font-semibold
                    {{ $item->status === 'terbayar' ? 'bg-emerald-100 text-emerald-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($item->status) }}
                </span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="px-4 py-2 text-center text-gray-500">Belum ada transaksi zakat.</td>
        </tr>
        @endforelse
    </tbody>
</table>
