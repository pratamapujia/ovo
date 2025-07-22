<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Models\Pemilih;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $config = Config::all();
        return view('auth.votersLogin', compact('config'));
    }

    public function prosesLoginVoters(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nis' => 'required',
            'password' => 'required',
        ], [
            'nis.required' => 'NIS tidak boleh kosong',
            'password.required' => 'Token tidak boleh kosong',
        ]);

        if ($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }
        // Cek konfigurasi pemilihan
        $voteDate = Config::where('name', 'vote_date')->first();
        $voteOpen = Config::where('name', 'vote_open')->first();
        $voteClosed = Config::where('name', 'vote_closed')->first();

        // Cek apakah konfigurasi pemilihan sudah diatur
        if ($voteDate && $voteOpen && $voteClosed) {
            $start = Carbon::parse($voteDate->value . ' ' . $voteOpen->value);
            $end = Carbon::parse($voteDate->value . ' ' . $voteClosed->value);
            $now = Carbon::now();

            // Cek apakah pemilihan sedang berlangsung
            if ($now->lt($start) || $now->gt($end)) {
                return redirect('/')->with(['error' => 'Pemilihan belum dimulai atau sudah berakhir']);
            } else {
                // Proses login pemilih
                if (Auth::guard('pemilih')->attempt(['nis' => $request->nis, 'password' => $request->password])) {
                    $pemilih = Pemilih::where('nis', $request->nis)->first();

                    // Cek apakah pemilih sudah memilih
                    if ($pemilih->status == 1) {
                        Auth::guard('pemilih')->logout(); // Logout jika sudah memilih
                        return redirect('/')->with(['error' => 'Anda sudah memilih']);
                    }

                    return redirect('/voting');
                } else {
                    return redirect('/')->with(['error' => 'NIS / Token salah']);
                }
            }
        }
    }

    public function logoutvoters()
    {

        Auth::guard('pemilih')->logout();
        return redirect('/');
    }

    public function indexAdmin()
    {
        return view('auth.adminLogin');
    }

    public function prosesLoginAdmin(Request $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        } else {
            return redirect('/panel')->with('error', 'Email atau password salah');
        }
    }

    public function logoutadmin()
    {
        Auth::guard('admin')->logout();
        return redirect('/panel');
    }
}
