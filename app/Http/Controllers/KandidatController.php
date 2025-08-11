<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kandidat = Kandidat::all();
        return view('admin.kandidat.index', compact('kandidat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kandidat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama_kandidat' => 'required',
            'no_urut' => 'required|numeric',
            'foto_kandidat' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'visi' => 'required',
            'misi' => 'required',
        ], [
            'nama_kandidat.required' => 'Nama kandidat wajib diisi',
            'no_urut.required' => 'Nomor urut wajib diisi',
            'no_urut.numeric' => 'Nomor urut harus berupa angka',
            'foto_kandidat.required' => 'Foto kandidat wajib diisi',
            'foto_kandidat.image' => 'Foto kandidat harus berupa gambar',
            'foto_kandidat.mimes' => 'Foto kandidat harus berformat jpeg, png, jpg',
            'foto_kandidat.max' => 'Foto kandidat maksimal 2MB',
            'visi.required' => 'Visi wajib diisi',
            'misi.required' => 'Misi wajib diisi',
        ]);

        if ($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        $kandidat = new Kandidat();
        $kandidat->nama_kandidat = $request->nama_kandidat;
        $kandidat->no_urut = $request->no_urut;
        $kandidat->visi = $request->visi;
        $kandidat->misi = $request->misi;

        if ($request->hasFile('foto_kandidat')) {
            $file = $request->file('foto_kandidat');
            $nama_file = time() . "_" . $kandidat->nama_kandidat . "." . 'webp';
            $file->move(storage_path('app/public/kandidat'), $nama_file);
            $kandidat->foto_kandidat = $nama_file;
        }
        if ($kandidat->save()) {
            return redirect()->route('kandidat.index')->with('pesan', 'Data berhasil disimpan 👍');
        } else {
            return redirect()->back()->with('gagal', 'Data gagal disimpan 😭');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kandidat = Kandidat::find($id);
        return view('admin.kandidat.edit', compact('kandidat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama_kandidat' => 'required',
            'no_urut' => 'required|numeric',
            'foto_kandidat' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'visi' => 'required',
            'misi' => 'required',
        ], [
            'nama_kandidat.required' => 'Nama kandidat wajib diisi',
            'no_urut.required' => 'Nomor urut wajib diisi',
            'no_urut.numeric' => 'Nomor urut harus berupa angka',
            'foto_kandidat.image' => 'Foto kandidat harus berupa gambar',
            'foto_kandidat.mimes' => 'Foto kandidat harus berformat jpeg, png, jpg',
            'foto_kandidat.max' => 'Foto kandidat maksimal 2MB',
            'visi.required' => 'Visi wajib diisi',
            'misi.required' => 'Misi wajib diisi',
        ]);

        if ($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        $kandidat = Kandidat::findOrFail($id);
        $kandidat->nama_kandidat = $request->nama_kandidat;
        $kandidat->no_urut = $request->no_urut;
        $kandidat->visi = $request->visi;
        $kandidat->misi = $request->misi;

        if ($request->hasFile('foto_kandidat')) {
            // Hapus foto lama jika ada
            if ($kandidat->foto_kandidat) {
                Storage::delete('public/kandidat/' . $kandidat->foto_kandidat);
            }

            $file = $request->file('foto_kandidat');
            $nama_file = time() . "_" . $kandidat->nama_kandidat . "." . 'webp';
            $file->move(storage_path('app/public/kandidat'), $nama_file);
            $kandidat->foto_kandidat = $nama_file;
        }

        if ($kandidat->save()) {
            return redirect()->route('kandidat.index')->with('pesan', 'Data berhasil diperbarui 👍');
        } else {
            return redirect()->back()->with('gagal', 'Data gagal diperbarui 😭');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kandidat = Kandidat::find($id);
        if ($kandidat->delete()) {
            return redirect()->route('kandidat.index')->with('pesan', 'Data berhasil dihapus 👍');
        } else {
            return redirect()->route('kandidat.index')->with('gagal', 'Data gagal dihapus 😭');
        }
    }
}
