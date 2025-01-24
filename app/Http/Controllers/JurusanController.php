<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusan = DB::table('jurusans')->get();
        return view('admin.jurusan.index', compact('jurusan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jurusan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama_jurusan' => 'required'
        ], [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi'
        ]);

        if ($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        $jurusan = new Jurusan();
        $jurusan->nama_jurusan = $request->nama_jurusan;
        if ($jurusan->save()) {
            return redirect()->route('jurusan.index')->with('pesan', 'Data berhasil disimpan 👍');
        } else {
            return redirect()->back()->with('gagal', 'Data gagal Disimpan 😭');
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
        $jurusan = DB::table('jurusans')->where('nama_jurusan', $id)->first();

        return view('admin.jurusan.edit', compact('jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama_jurusan' => 'required'
        ], [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi'
        ]);

        if ($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        $jurusan = Jurusan::find($id);
        $jurusan->nama_jurusan = $request->nama_jurusan;
        if ($jurusan->save()) {
            return redirect()->route('jurusan.index')->with('pesan', 'Data berhasil diupdate');
        } else {
            return redirect()->back()->with('gagal', 'Data gagal diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jurusan = Jurusan::find($id);
        if ($jurusan->delete()) {
            return redirect()->route('jurusan.index')->with('pesan', 'Data berhasil dihapus 👍');
        } else {
            return redirect()->route('jurusan.index')->with('gagal', 'Data gagal dihapus 😭');
        }
    }
}
