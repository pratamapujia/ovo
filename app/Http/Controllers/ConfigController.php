<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    public function index()
    {
        $config = Config::all();
        return view('admin.config.index', compact('config'));
    }

    public function update(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'app_name' => 'required|string|max:50',
            'vote_date' => 'nullable|date',
            'vote_open' => 'nullable|date_format:H:i',
            'vote_closed' => 'nullable|date_format:H:i',
            'app_logo' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'app_name.required' => 'Nama aplikasi wajib diisi',
            'app_name.string' => 'Nama aplikasi harus berupa string',
            'app_name.max' => 'Nama aplikasi maksimal 50 karakter',
            'vote_date.date' => 'Format tanggal tidak sesuai',
            'vote_open.date_format' => 'Format waktu tidak sesuai',
            'vote_closed.date_format' => 'Format waktu tidak sesuai',
            'app_logo.file' => 'Format file tidak sesuai',
            'app_logo.image' => 'Format file tidak sesuai',
            'app_logo.mimes' => 'Format file tidak sesuai',
            'app_logo.max' => 'Ukuran file maksimal 2MB',
        ]);

        if ($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        // Update konfigurasi
        Config::where('name', 'app_name')->update(['value' => $request->app_name]);
        Config::where('name', 'vote_date')->update(['value' => $request->vote_date]);
        Config::where('name', 'vote_open')->update(['value' => $request->vote_open]);
        Config::where('name', 'vote_closed')->update(['value' => $request->vote_closed]);

        if ($request->hasFile('app_logo')) {
            $app_logo = $request->file('app_logo');
            $app_logo_name = time() . '.' . $app_logo->getClientOriginalExtension();
            $app_logo->move(storage_path('app/public/apps'), $app_logo_name);
            Config::where('name', 'app_logo')->update(['value' => $app_logo_name]);
        }

        return redirect()->route('config.index')->with('pesan', 'Konfigurasi berhasil diupdate 👍');
    }
}
