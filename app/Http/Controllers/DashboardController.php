<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Config;
use App\Models\Pemilih;
use App\Models\Kandidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $pemilih = Pemilih::all();
        $kandidat = Kandidat::all();
        $config = Config::all();
        return view('index', compact('pemilih', 'kandidat', 'config'));
    }

    public function dashboardAdmin()
    {
        $jumlah_pemilih = Pemilih::all()->count();
        $jumlah_kandidat = Kandidat::all()->count();

        // Hitung jumlah pemilih yang sudah memilih
        $jumlah_sudah_memilih = Pemilih::where('status', 1)->count();

        // Hitung jumlah pemilih yang belum memilih
        $jumlah_belum_memilih = Pemilih::where('status', 0)->count();

        return view('admin.index', compact('jumlah_pemilih', 'jumlah_kandidat', 'jumlah_sudah_memilih', 'jumlah_belum_memilih'));
    }

    public function voting(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'kandidat_id' => 'required|exists:kandidats,id'
        ]);

        // Ambil data pemilih yang sedang login
        $pemilih = Auth::guard('pemilih')->user();

        // Update status pemilih dan kandidat yang dipilih
        $pemilih->update([
            'status' => 1,
            'kandidat_id' => $request->kandidat_id
        ]);

        return redirect()->back()->with('success', 'Voting berhasil 👍');
    }

    public function sudahMemilih()
    {
        $pemilih = Pemilih::where('status', 1)->get();
        $kelas = Kelas::all();
        return view('admin.subdashboard.sudahMemilih', compact('pemilih', 'kelas'));
    }
    public function belumMemilih()
    {
        $pemilih = Pemilih::where('status', 0)->get();
        $kelas = Kelas::all();
        return view('admin.subdashboard.belumMemilih', compact('pemilih', 'kelas'));
    }

    public function hasilPemilu()
    {
        // Ambil data hasil pemilihan
        $hasil = Pemilih::select('kandidat_id', DB::raw('count(*) as total_suara'))
            ->groupBy('kandidat_id')
            ->with('kandidat')
            ->get();

        // Siapkan data untuk chart
        $chartData = [];

        //filter hasil pemilihan yang memiliki kandidat
        foreach ($hasil as $item) {
            if ($item->kandidat && $item->kandidat->nama_kandidat) {
                $chartData[] = [
                    'nama_kandidat' => $item->kandidat->nama_kandidat,
                    'total_suara' => $item->total_suara
                ];
            }
        }

        return view('admin.hasil', compact('chartData'));
    }
}
