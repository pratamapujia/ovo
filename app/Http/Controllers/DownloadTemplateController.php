<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadTemplateController extends Controller
{
    public function template()
    {
        $file_path = public_path('template.xlsx');
        $fileName = 'template.xlsx';

        // Pastikan file template ada
        if (!file_exists($file_Path)) {
            abort(404, 'File template tidak ditemukan.');
        }

        return response()->download($file_Path, $fileName);
    }
}
