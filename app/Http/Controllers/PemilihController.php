<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pemilih;
use App\Imports\VotersImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use PDF;

class PemilihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemilih = Pemilih::orderby('nis', 'asc')->get();
        $kelas = Kelas::all();
        return view('admin.pemilih.index', compact('pemilih', 'kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.pemilih.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nis' => 'required|unique:voters,nis',
            'nama_pemilih' => 'required|max:50',
            'kelas_id' => 'required',
        ], [
            'nis.required' => 'NIS wajib diisi',
            'nis.unique' => 'NIS sudah terdaftar',
            'nama_pemilih.required' => 'Nama pemilih wajib diisi',
            'nama_pemilih.max' => 'Nama pemilih maksimal 50 karakter',
            'kelas_id.required' => 'Pilih kelas terlebih dahulu'
        ]);

        if ($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        $pemilih = new Pemilih();
        $pemilih->nis = $request->nis;
        $pemilih->nama_pemilih = $request->nama_pemilih;
        $pemilih->kelas_id = $request->kelas_id;
        $pemilih->token = strtoupper(Str::random(5));
        $pemilih->password = bcrypt($pemilih->token);
        if ($pemilih->save()) {
            return redirect()->route('pemilih.index')->with('pesan', 'Data berhasil disimpan 👍');
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
        $pemilih = Pemilih::find($id);
        $kelas = Kelas::all();
        return view('admin.pemilih.edit', compact('pemilih', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(), [
            'nis' => 'required',
            'nama_pemilih' => 'required|max:50',
            'kelas_id' => 'required',
        ], [
            'nis.required' => 'NIS wajib diisi',
            'nama_pemilih.required' => 'Nama pemilih wajib diisi',
            'nama_pemilih.max' => 'Nama pemilih maksimal 50 karakter',
            'kelas_id.required' => 'Pilih kelas terlebih dahulu'
        ]);

        if ($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        $pemilih = Pemilih::find($id);
        $pemilih->nis = $request->nis;
        $pemilih->nama_pemilih = $request->nama_pemilih;
        $pemilih->kelas_id = $request->kelas_id;
        $pemilih->token = strtoupper(Str::random(5));
        $pemilih->password = bcrypt($pemilih->token);

        if ($pemilih->save()) {
            return redirect()->route('pemilih.index')->with('pesan', 'Data berhasil diperbarui 👍');
        } else {
            return redirect()->back()->with('gagal', 'Data gagal diperbarui 😭');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pemilih = Pemilih::find($id);
        if ($pemilih->delete()) {
            return redirect()->route('pemilih.index')->with('pesan', 'Data berhasil dihapus 👍');
        } else {
            return redirect()->route('pemilih.index')->with('gagal', 'Data gagal dihapus 😭');
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
            Excel::import(new VotersImport, $request->file('input_excel'));
            // 3. Jika berhasil, kembalikan dengan pesan sukses
            return redirect()->route('pemilih.index')->with('pesan', 'Data pemilih berhasil diimport! 👍');
        } catch (ValidationException $e) {
            // 4. Jika terjadi error validasi
            $failures = $e->failures();
            $errorMessages = [];

            foreach ($failures as $failure) {
                $errorMessages[] = "Baris ke-<b>" . $failure->row() . "</b>: " . implode(', ', $failure->errors());
            }

            // Siapkan data error untuk dikirim sebagai array
            $pesanGagal = [
                'type' => 'danger',
                'title' => 'Gagal Mengimpor Data!',
                'body' => 'Terdapat beberapa kesalahan pada file Anda:',
                'details' => $errorMessages // Kirim detail error dalam array terpisah
            ];
            return redirect()->route('pemilih.index')->with('pesan_alert', $pesanGagal);
        } catch (\Exception $e) {
            // 5. Tangani error umum lainnya
            $pesanGagal = [
                'type' => 'danger',
                'title' => 'Terjadi Kesalahan!',
                'body' => 'Tidak dapat memproses file: ' . $e->getMessage()
            ];
            return redirect()->route('pemilih.index')->with('pesan_alert', $pesanGagal);
        }
    }

    public function exportIndex(string $id)
    {
        $pemilih = Pemilih::where('kelas_id', $id)->with('kelas')->get();
        $kelas = Kelas::find($id);

        $data = [
            'title' => 'Akun Pemilih',
            'pemilih' => $pemilih,
            'kelas' => $kelas
        ];

        // $pdf = PDF::loadview('admin.pemilih.export', $data);
        // return $pdf->download('akun-pemilih.pdf');
        return view('admin.pemilih.export', $data);
    }
}
