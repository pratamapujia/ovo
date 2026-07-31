<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class KelasImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    private $jurusan;

    public function __construct()
    {
        // Menyimpan data jurusan ke dalam memori agar tidak query berulang kali
        // Asumsi: tabel jurusan memiliki kolom 'nama_jurusan'
        $this->jurusan = Jurusan::pluck('id', 'nama_jurusan');
    }

    public function model(array $row)
    {
        // Mencari jurusan_id dari data yang sudah di-cache
        $jurusanId = $this->jurusan[$row['nama_jurusan']] ?? null;

        return new Kelas([
            'nama_kelas' => $row['nama_kelas'],
            'jurusan_id' => $jurusanId,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_kelas' => 'required|string|max:10|unique:kelas,nama_kelas',
            'nama_jurusan' => 'required|string|exists:jurusans,nama_jurusan',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama_kelas.required' => 'Nama kelas tidak boleh kosong pada baris :attribute.',
            'nama_kelas.unique' => 'Nama kelas :value sudah terdaftar di database.',
            'nama_kelas.max' => 'Nama kelas maksimal 10 karakter.',
            'nama_jurusan.exists' => 'Jurusan :value tidak ditemukan di database. Pastikan penulisannya sama.',
        ];
    }
}
