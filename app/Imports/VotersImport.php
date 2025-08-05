<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Pemilih;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class VotersImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    private $kelas;
    // private $current = 0;

    public function __construct()
    {
        $this->kelas = Kelas::pluck('id', 'nama_kelas');
    }

    public function model(array $row)
    {
        //dd($row);
        // Mencari kelas_id dari data yang sudah di-cache
        $kelasId = $this->kelas[$row['nama_kelas']] ?? null;
        $token = strtoupper(Str::random(5)); // Generate token acak

        return new Pemilih([
            'nis'            => $row['nis'],
            'nama_pemilih'   => $row['nama_pemilih'],
            'kelas_id'       => $kelasId,
            'token'          => $token,
            'status'         => 0, // Status default 'Belum Memilih'
            'password'       => bcrypt($token)
        ]);
    }

    public function rules(): array
    {
        return [
            'nis' => 'required|numeric|unique:voters,nis',
            'nama_pemilih' => 'required|string',
            'nama_kelas' => 'required|string|exists:kelas,nama_kelas',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nis.required' => 'NIS tidak boleh kosong pada baris :attribute.',
            'nis.unique' => 'NIS :value sudah terdaftar di database.',
            'nama_kelas.exists' => 'Kelas :value tidak ditemukan di database.',
        ];
    }
}
