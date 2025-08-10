<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Config;

class ConfigsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TYPE[
        //     0 = TEXT,
        //     1 = TEXTAREA,
        //     2 = FILE,
        //     3 = SELECT, 
        //     4 = Date,
        //     5 = Time,
        // ] 
        Config::create([
            'name' => 'app_name',
            'label' => 'Nama Aplikasi',
            'value' => 'Online Voting',
            'type' => 0,
        ]);

        Config::create([
            'name'  => 'app_logo',
            'label' => 'Logo',
            'type'  => 2
        ]);

        Config::create([
            'name'  => 'poster',
            'label' => 'Poster',
            'type'  => 2
        ]);

        Config::create([
            'name'  => 'vote_date',
            'label' => 'Tanggal Pemilihan',
            'value' => '',
            'type'  => 4
        ]);

        Config::create([
            'name'  => 'vote_open',
            'label' => 'Jam Mulai',
            'value' => '',
            'type'  => 5
        ]);

        Config::create([
            'name'  => 'vote_closed',
            'label' => 'Jam Selesai',
            'value' => '',
            'type'  => 5
        ]);
    }
}
