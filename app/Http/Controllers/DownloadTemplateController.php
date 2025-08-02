<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadTemplateController extends Controller
{
    public function template()
    {
        $file_path = public_path('templates/template.xlsx');
        $fileName = 'template.xlsx';

        if (file_exists($file_path)) {
            return response()->download($file_path, $fileName);
        } else {
            abort(404, 'File tidak ditemukan');
        }
    }
}
