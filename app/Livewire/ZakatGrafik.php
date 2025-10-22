<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TransaksiZakat;

class ZakatGrafik extends Component
{
    public $dataGrafik = [];

    public function mount()
    {
        $this->dataGrafik = TransaksiZakat::selectRaw('EXTRACT(MONTH FROM tanggal) as bulan, SUM(nominal) as total')
            ->where('status', 'terbayar')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->map(function ($item) {
                return [
                    'bulan' => $this->namaBulan((int) $item->bulan),
                    'total' => (int) $item->total,
                ];
            })
            ->toArray();

        // Fallback dummy jika kosong
        if (empty($this->dataGrafik)) {
            $this->dataGrafik = collect(range(1, 12))->map(function ($bulan) {
                return [
                    'bulan' => $this->namaBulan($bulan),
                    'total' => 0,
                ];
            })->toArray();
        }
    }

    public function render()
    {
        return view('livewire.zakat-grafik', [
            'dataGrafik' => $this->dataGrafik
        ]);
    }

    private function namaBulan($angka)
    {
        $bulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        return $bulan[$angka] ?? 'N/A';
    }
}
