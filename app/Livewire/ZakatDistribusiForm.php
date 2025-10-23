<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DistribusiZakat;
use App\Models\Mustahik;
use App\Models\JenisBantuan;

class ZakatDistribusiForm extends Component
{
    public $mustahik_id;
    public $jenis_bantuan_id;
    public $jenis_bantuan_slug = null;
    public $jumlah;
    public $tanggal;
    public $status = 'disalurkan';
    public $detail = [];

    public function mount()
    {
        if ($this->jenis_bantuan_id) {
            $this->syncJenisBantuanSlug($this->jenis_bantuan_id);
        }
    }

    public function updatedJenisBantuanId($value)
    {
        $this->detail = [];
        $this->syncJenisBantuanSlug($value);
    }

    protected function syncJenisBantuanSlug($id)
    {
        $bantuan = JenisBantuan::find($id);
        $this->jenis_bantuan_slug = $bantuan?->slug;
    }

    protected function rules()
    {
        $baseRules = [
            'mustahik_id' => 'required|exists:mustahik,id',
            'jenis_bantuan_id' => 'required|exists:jenis_bantuan,id',
            'jumlah' => in_array($this->jenis_bantuan_slug, ['uang-tunai', 'beasiswa']) 
                ? 'nullable' 
                : 'required|numeric|min:1',
            'tanggal' => 'required|date',
        ];

        $modularRules = match ($this->jenis_bantuan_slug) {
            'sembako' => [
                'detail.jenis_barang' => 'required|string',
                'detail.jumlah_paket' => 'required|numeric|min:1',
            ],
            'modal-usaha' => [
                'detail.jenis_usaha' => 'required|string',
                'detail.modal' => 'required|numeric|min:1',
                'detail.pendampingan' => 'nullable|string',
            ],
            'kesehatan' => [
                'detail.nama_pasien' => 'required|string',
                'detail.jenis_pengobatan' => 'required|string',
                'detail.biaya' => 'required|numeric|min:1',
            ],
            'uang-tunai' => [
                'detail.tujuan' => 'required|string',
                'detail.nominal' => 'required|numeric|min:1',
            ],
            'beasiswa' => [
                'detail.nama_siswa' => 'required|string',
                'detail.jenjang' => 'required|string',
                'detail.biaya' => 'required|numeric|min:1',
            ],
            default => [],
        };

        return array_merge($baseRules, $modularRules);
    }

    public function submit()
    {
        $this->validate();

        DistribusiZakat::create([
            'mustahik_id' => $this->mustahik_id,
            'jenis_bantuan_id' => $this->jenis_bantuan_id,
            'jumlah' => $this->jumlah,
            'tanggal' => $this->tanggal,
            'status' => $this->status,
            'detail_json' => json_encode($this->detail),
        ]);

        $this->resetForm();
        session()->flash('success', 'Distribusi zakat berhasil disimpan.');
    }

    protected function resetForm()
    {
        $this->reset([
            'mustahik_id',
            'jenis_bantuan_id',
            'jenis_bantuan_slug',
            'jumlah',
            'tanggal',
            'status',
            'detail',
        ]);
    }

    public function render()
    {
        return view('livewire.zakat-distribusi-form', [
            'mustahikList' => Mustahik::all(),
            'bantuanList' => JenisBantuan::all(),
        ]);
    }
}
