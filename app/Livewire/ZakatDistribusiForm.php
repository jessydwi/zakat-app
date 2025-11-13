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
            'jumlah' => in_array($this->jenis_bantuan_slug, ['uang-tunai', 'beasiswa', 'kesehatan', 'modal-usaha']) 
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
                'detail.jenis_pengobatan' => 'required|string',
                'detail.biaya' => 'required|numeric|min:1',
            ],
            'uang-tunai' => [
                'detail.tujuan' => 'required|string',
                'detail.nominal' => 'required|numeric|min:1',
            ],
            'beasiswa' => [
                'detail.jenjang' => 'required|string',
                'detail.biaya' => 'required|numeric|min:1',
            ],
            default => [],
        };

        return array_merge($baseRules, $modularRules);
    }

    /** 🔧 Bangun detail_json dengan fallback nama mustahik */
    protected function buildDetailJson(): array
    {
        $mustahik = Mustahik::find($this->mustahik_id);
        $slug = $this->jenis_bantuan_slug;

        return match ($slug) {
            'uang-tunai' => [
                'nama_penerima' => $this->detail['nama_penerima'] ?? $mustahik?->nama,
                'nominal' => $this->detail['nominal'] ?? $this->jumlah,
                'tujuan' => $this->detail['tujuan'] ?? null,
            ],
            'beasiswa' => [
                'nama_siswa' => $this->detail['nama_siswa'] ?? $mustahik?->nama,
                'jenjang' => $this->detail['jenjang'] ?? null,
                'biaya' => $this->detail['biaya'] ?? $this->jumlah,
            ],
            'kesehatan' => [
                'nama_pasien' => $this->detail['nama_pasien'] ?? $mustahik?->nama,
                'jenis_pengobatan' => $this->detail['jenis_pengobatan'] ?? null,
                'biaya' => $this->detail['biaya'] ?? $this->jumlah,
            ],
            'modal-usaha' => [
                'jenis_usaha' => $this->detail['jenis_usaha'] ?? null,
                'modal' => $this->detail['modal'] ?? $this->jumlah,
                'pendampingan' => $this->detail['pendampingan'] ?? null,
            ],
            'sembako' => [
                'jumlah_paket' => $this->detail['jumlah_paket'] ?? null,
                'jenis_barang' => $this->detail['jenis_barang'] ?? null,
            ],
            default => $this->detail ?? [],
        };
    }

    /** 🔧 Tentukan jumlah berdasarkan jenis bantuan */
    protected function resolveJumlah(): int
    {
        return match ($this->jenis_bantuan_slug) {
            'uang-tunai' => (int) ($this->detail['nominal'] ?? $this->jumlah),
            'beasiswa' => (int) ($this->detail['biaya'] ?? $this->jumlah),
            'kesehatan' => (int) ($this->detail['biaya'] ?? $this->jumlah),
            'modal-usaha' => (int) ($this->detail['modal'] ?? $this->jumlah),
            default => (int) ($this->jumlah ?? 0),
        };
    }

    public function submit()
    {
        $this->validate();
        $this->syncJenisBantuanSlug($this->jenis_bantuan_id);

        $detail = $this->buildDetailJson();
        $jumlah = $this->resolveJumlah();

        DistribusiZakat::create([
            'mustahik_id' => $this->mustahik_id,
            'jenis_bantuan_id' => $this->jenis_bantuan_id,
            'jumlah' => $jumlah,
            'tanggal' => $this->tanggal,
            'status' => $this->status,
            'detail_json' => json_encode($detail),
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
