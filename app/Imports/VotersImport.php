<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Pemilih;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class VotersImport implements ToModel, WithHeadingRow, WithValidation
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

        // $this->current++;
        // if ($this->current > 1) {
        //     $count = Pemilih::where('nis', '=', $row[0])->count();
        //     if (empty($count)) {
        //         $pemilih = new Pemilih;
        //         $pemilih->nis = $row[0];
        //         $pemilih->nama_pemilih = $row[1];
        //         $pemilih->kelas_id = $row[2];
        //         $pemilih->token = strtoupper(Str::random(5));
        //         $pemilih->password = bcrypt($pemilih->token);
        //         $pemilih->save();
        //     }
        // }
    }

    public function rules(): array
    {
        return [
            // 'nis' adalah nama kolom di file Excel
            'nis' => 'required|numeric|unique:voters,nis',

            // 'nama_pemilih' adalah nama kolom di file Excel
            'nama_pemilih' => 'required|string',

            // 'nama_kelas' adalah nama kolom di file Excel
            // 'exists:kelas,nama_kelas' akan memvalidasi apakah nama kelas ini ada di tabel 'kelas' pada kolom 'nama_kelas'
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
