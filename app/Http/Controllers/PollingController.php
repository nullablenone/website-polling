<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Jawaban;
use App\Models\Polling;
use App\Models\BatasPolling;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class PollingController extends Controller
{

    public function dashboard()
    {
        $user = Auth::user();
        $pollings = $user->polling;
        return view('Polling.dashboard', ['pollings' => $pollings]);
    }

    // Menampilkan form untuk membuat polling baru
    public function create()
    {
        return view('Polling.create');
    }


    // Menyimpan polling baru ke database
    public function store(Request $request)
    {
        // Validasi input dari form polling
        $validated = $request->validate([
            'title' => 'required|min:5',
            'option' => 'required|array',
            'option.*' => 'required|string',
        ]);

        $maxPolling = 3; // Batas maksimal polling per user
        $user = Auth::user(); // Ambil user yang lagi login
        $ipAddress = $request->ip(); // Ambil IP address user

        // Cek apakah user ini sudah bikin polling melebihi batas
        $pollingCount = Polling::where('user_id', $user->id)->count();

        if ($pollingCount >= $maxPolling) {
            return back()->with('error', 'Anda telah mencapai batas maksimal polling.');
        }

        // Cek apakah ada polling dari IP yang sama
        $ipTracking = BatasPolling::where('ip_address', $ipAddress)->where('user_id', $user->id)->first();

        if ($ipTracking && $ipTracking->jumlah_polling >= $maxPolling) {
            return back()->with('error', 'Anda telah mencapai batas polling dari IP ini.');
        }

        // Update atau buat entry IP baru
        if ($ipTracking) {
            $ipTracking->jumlah_polling++;
            $ipTracking->save();
        } else {
            $ipTracking = new BatasPolling;
            $ipTracking->ip_address = $ipAddress;
            $ipTracking->user_id = $user->id;
            $ipTracking->jumlah_polling = 1;
            $ipTracking->save();
        }

        // Simpan polling baru
        $polling = new Polling;
        $polling->title = $request->title;
        $polling->user_id = $user->id; // Simpan user ID dari user yang lagi login
        $polling->save();

        // Simpan opsi/jawaban
        foreach ($request->option as $option) {
            $jawaban = new Jawaban;
            $jawaban->polling_id = $polling->id;
            $jawaban->option = $option;
            $jawaban->save();
        }

        return redirect()->route('polling.show', $polling->id);
    }




    // Menampilkan detail polling berdasarkan ID
    public function show(string $id)
    {
        $polling = Polling::findOrFail($id); // Ambil polling dari database berdasarkan ID

        return view('Polling.show', ['polling' => $polling]); // Tampilkan polling di view
    }


    // Proses pemungutan suara/vote
    public function vote(Request $request, $id)
    {
        // Validasi input: pastikan jawaban_id ada di tabel jawabans
        $validated = $request->validate([
            'jawaban_id' => 'required|exists:jawabans,id',
        ]);

        $ipAddress = $request->ip(); // Mendapatkan IP address pengguna

        // Ambil polling terkait dengan jawaban_id yang dipilih
        $pollingId = Jawaban::where('id', $request->jawaban_id)->value('polling_id');

        // Cek apakah IP sudah pernah vote untuk polling ini
        $existingVote = Vote::where('polling_id', $pollingId)
            ->where('ip_address', $ipAddress)
            ->first();

        // Jika sudah pernah vote, beri feedback dan redirect
        if ($existingVote) {
            return redirect()->route('polling.show', $pollingId)->with('error', 'Anda sudah melakukan vote.');
        }

        // Menambah jumlah vote untuk jawaban yang dipilih
        $jawaban = Jawaban::findOrFail($request->jawaban_id);
        $jawaban->vote += 1; // Tambahkan 1 vote
        $jawaban->save(); // Simpan perubahan ke database

        // Simpan IP address ke tabel 'votes' untuk mencegah vote duplikat
        $vote = new Vote;
        $vote->polling_id = $pollingId; // Hubungkan vote dengan polling
        $vote->ip_address = $ipAddress; // Simpan IP address pengguna
        $vote->save(); // Simpan vote ke database

        // Redirect ke halaman status polling
        return redirect()->route('polling.showStatus', $pollingId);
    }


    // Menampilkan status polling (hasil vote) berdasarkan ID
    public function showStatus($id)
    {
        $polling = Polling::findOrFail($id); // Ambil polling dari database berdasarkan ID
        return view('Polling.showStatus', ['polling' => $polling]); // Tampilkan status polling di view
    }


    // Menampilkan polling berdasarkan ID
    public function showPolling($id)
    {
        $polling = Polling::findOrFail($id); // Ambil polling dari database berdasarkan ID
        return view('Polling.showPolling', ['polling' => $polling]); // Tampilkan polling di view
    }


    // Menampilkan polling berdasarkan yang terbaru
    public function pollingTerbaru(Request $request)
    {
        // Ambil query pencarian dari input
        $query = $request->input('query');

        // Cek apakah ada query pencarian
        if ($query) {
            // Jika ada, cari polling berdasarkan title
            $polling = Polling::where('title', 'LIKE', "%{$query}%")
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Jika tidak ada, ambil semua polling yang diurutkan
            $polling = Polling::orderBy('created_at', 'desc')->get();
        }

        // Cek apakah hasil polling ada atau tidak
        $kondisi = $polling->isEmpty();

        return view('Polling.pollingTerbaru', [
            'pollings' => $polling,
            'query' => $query,
            'kondisi' => $kondisi // Kirim variabel kondisi ke view
        ]);
    }




    // Menampilkan halaman "tentang"
    public function tentang()
    {
        return view('polling.tentang');
    }
}
