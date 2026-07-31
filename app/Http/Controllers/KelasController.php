<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Imports\KelasImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::with('jurusan')->orderBy('nama_kelas', 'desc')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan = Jurusan::all();
        return view('admin.kelas.create', compact('jurusan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:10',
            'jurusan_id' => 'required'
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi',
            'nama_kelas.string' => 'Nama kelas harus berupa string',
            'nama_kelas.max' => 'Nama kelas maksimal 10 karakter',
            'jurusan_id.required' => 'Pilih jurusan terlebih dahulu'
        ]);

        if ($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        $kelas = new Kelas();
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->jurusan_id = $request->jurusan_id;
        if ($kelas->save()) {
            return redirect()->route('kelas.index')->with('pesan', 'Data berhasil disimpan 👍');
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
        $kelas = Kelas::find($id);
        $jurusan = Jurusan::all();
        return view('admin.kelas.edit', compact('kelas', 'jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:10',
            'jurusan_id' => 'required'
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi',
            'nama_kelas.string' => 'Nama kelas harus berupa string',
            'nama_kelas.max' => 'Nama kelas maksimal 10 karakter',
            'jurusan_id.required' => 'Pilih jurusan terlebih dahulu'
        ]);

        if ($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        $kelas = Kelas::find($id);
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->jurusan_id = $request->jurusan_id;
        if ($kelas->save()) {
            return redirect()->route('kelas.index')->with('pesan', 'Data berhasil diperbarui 👍');
        } else {
            return redirect()->back()->with('gagal', 'Data gagal diperbarui 😭');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = Kelas::find($id);
        if ($kelas->delete()) {
            return redirect()->route('kelas.index')->with('pesan', 'Data berhasil dihapus 👍');
        } else {
            return redirect()->route('kelas.index')->with('gagal', 'Data gagal dihapus 😭');
        }
    }

    public function import(Request $request)
    {
        // 1. Validasi file yang diupload
        $request->validate([
            'input_excel' => 'required|mimes:xls,xlsx'
        ]);

        try {
            // 2. Lakukan import
            Excel::import(new KelasImport, $request->file('input_excel'));

            // 3. Jika berhasil, kembalikan dengan pesan sukses
            return redirect()->route('kelas.index')->with('pesan', 'Data kelas berhasil diimport! 👍');
        } catch (ValidationException $e) {
            // 4. Jika terjadi error validasi dari file Excel
            $failures = $e->failures();
            $errorMessages = [];

            foreach ($failures as $failure) {
                $errorMessages[] = "Baris ke-<b>" . $failure->row() . "</b>: " . implode(', ', $failure->errors());
            }

            $pesanGagal = [
                'type' => 'danger',
                'title' => 'Gagal Mengimpor Data!',
                'body' => 'Terdapat beberapa kesalahan pada file Anda:',
                'details' => $errorMessages
            ];
            return redirect()->route('kelas.index')->with('pesan_alert', $pesanGagal);
        } catch (\Exception $e) {
            // 5. Tangani error umum lainnya
            $pesanGagal = [
                'type' => 'danger',
                'title' => 'Terjadi Kesalahan!',
                'body' => 'Tidak dapat memproses file: ' . $e->getMessage()
            ];
            return redirect()->route('kelas.index')->with('pesan_alert', $pesanGagal);
        }
    }
}
