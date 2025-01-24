<?php

namespace App\Imports;

use App\Models\Pemilih;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class VotersImport implements ToCollection, ToModel
{
    private $current = 0;
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // dd($collection);
    }

    public function model(array $row)
    {
        $this->current++;
        if ($this->current > 1) {
            $count = Pemilih::where('nis', '=', $row[0])->count();
            if (empty($count)) {
                $pemilih = new Pemilih;
                $pemilih->nis = $row[0];
                $pemilih->nama_pemilih = $row[1];
                $pemilih->kelas_id = $row[2];
                $pemilih->token = strtoupper(Str::random(5));
                $pemilih->password = bcrypt($pemilih->token);
                $pemilih->save();
            }
        }
    }
}
