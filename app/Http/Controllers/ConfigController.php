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
            'poster' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048',
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
            'poster.file' => 'Format file tidak sesuai',
            'poster.image' => 'Format file tidak sesuai',
            'poster.mimes' => 'Format file tidak sesuai',
            'poster.max' => 'Ukuran file maksimal 2MB',
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
            // 1. Ambil data logo lama dari database
            $old_logo_config = Config::where('name', 'app_logo')->first();

            // 2. Cek jika ada file lama dan hapus dari storage
            if ($old_logo_config && $old_logo_config->value) {
                // Path file lama di dalam folder storage/app/public/apps/
                $old_logo_path = 'public/apps/' . $old_logo_config->value;
                if (Storage::exists($old_logo_path)) {
                    Storage::delete($old_logo_path);
                }
            }

            // 3. Simpan file baru
            $app_logo = $request->file('app_logo');
            $app_logo_name = 'logo-' . time() . '.' . $app_logo->getClientOriginalExtension();
            $app_logo->move(storage_path('app/public/apps'), $app_logo_name);

            // 4. Update nama file baru di database
            Config::where('name', 'app_logo')->update(['value' => $app_logo_name]);
        }

        if ($request->hasFile('poster')) {
            // 1. Ambil data poster lama dari database
            $old_poster_config = Config::where('name', 'poster')->first();

            // 2. Cek jika ada file lama dan hapus dari storage
            if ($old_poster_config && $old_poster_config->value) {
                // Path file lama di dalam folder storage/app/public/apps/
                $old_poster_path = 'public/apps/' . $old_poster_config->value;
                if (Storage::exists($old_poster_path)) {
                    Storage::delete($old_poster_path);
                }
            }

            // 3. Simpan file baru
            $poster = $request->file('poster');
            $poster_name = 'poster-' . time() . '.' . $poster->getClientOriginalExtension();
            $poster->move(storage_path('app/public/apps'), $poster_name);

            // 4. Update nama file baru di database
            Config::where('name', 'poster')->update(['value' => $poster_name]);
        }

        return redirect()->route('config.index')->with('pesan', 'Konfigurasi berhasil diupdate 👍');
    }
}
