<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\JenisBantuan;

class DistribusiZakatRequest extends FormRequest
{
    public function rules(): array
    {
        $slug = JenisBantuan::find($this->jenis_bantuan_id)?->slug;

        $base = [
            'mustahik_id' => 'required|exists:mustahik,id',
            'jenis_bantuan_id' => 'required|exists:jenis_bantuan,id',
            'tanggal' => 'required|date',
            'jumlah' => in_array($slug, ['uang-tunai', 'beasiswa']) ? 'nullable' : 'required|numeric|min:1',
        ];

        $modular = match ($slug) {
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

        return array_merge($base, $modular);
    }
}

