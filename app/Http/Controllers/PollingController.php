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

    public function pollingFoto()
    {
        return view("Polling.polling-foto");
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

        $maxPolling = 1; // Batas maksimal polling per user
        $user = Auth::user(); // Ambil user yang lagi login
        $ipAddress = $request->ip(); // Ambil IP address user

        // Cek apakah user ini sudah bikin polling melebihi batas
        $pollingCount = BatasPolling::sum('jumlah_polling');

        if ($pollingCount >= $maxPolling) {
            return back()->with('error', 'Anda telah mencapai batas maksimal polling untuk akun ini.');
        }

        // Cek apakah sudah ada entry di BatasPolling untuk kombinasi user_id dan ip_address
        $ipTracking = BatasPolling::where('ip_address', $ipAddress)->where('user_id', $user->id)->first();

        // Jika ada, cek apakah sudah mencapai batas polling berdasarkan IP
        if ($ipTracking && $ipTracking->jumlah_polling >= $maxPolling) {
            return back()->with('error', 'Anda telah mencapai batas polling dari IP ini.');
        }

        // Update atau buat entry baru di BatasPolling
        if ($ipTracking) {
            $ipTracking->jumlah_polling++;
            $ipTracking->save();
        } else {
            try {
                // Jika belum ada entry, buat entry baru dengan kombinasi user_id dan ip_address
                $ipTracking = new BatasPolling;
                $ipTracking->ip_address = $ipAddress;
                $ipTracking->user_id = $user->id;
                $ipTracking->jumlah_polling = 1;
                $ipTracking->save();
            } catch (\Exception $e) {
                return back()->with('error', 'Kamu terdekesi melakukan spam Akun!');
            }
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


    public function storeFotoPolling(Request $request)
    {
        // Validasi input dari form polling foto
        $validated = $request->validate([
            'title' => 'required|min:5',
            'option' => 'required|array',
            'option.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi untuk foto
        ]);

        $maxPolling = 3;
        $user = Auth::user();
        $ipAddress = $request->ip();

        // Cek apakah user ini sudah bikin polling melebihi batas
        $pollingCount = Polling::where('user_id', $user->id)->count();

        if ($pollingCount >= $maxPolling) {
            return back()->with('error', 'Anda telah mencapai batas maksimal polling untuk akun ini.');
        }

        // Cek apakah sudah ada entry di BatasPolling untuk kombinasi user_id dan ip_address
        $ipTracking = BatasPolling::where('ip_address', $ipAddress)->where('user_id', $user->id)->first();

        // Jika ada, cek apakah sudah mencapai batas polling berdasarkan IP
        if ($ipTracking && $ipTracking->jumlah_polling >= $maxPolling) {
            return back()->with('error', 'Anda telah mencapai batas polling dari IP ini.');
        }

        // Update atau buat entry baru di BatasPolling
        if ($ipTracking) {
            $ipTracking->jumlah_polling++;
            $ipTracking->save();
        } else {
            try {
                // Jika belum ada entry, buat entry baru dengan kombinasi user_id dan ip_address
                $ipTracking = new BatasPolling;
                $ipTracking->ip_address = $ipAddress;
                $ipTracking->user_id = $user->id;
                $ipTracking->jumlah_polling = 1;
                $ipTracking->save();
            } catch (\Exception $e) {
                return back()->with('error', 'Jangan Spam Bang !');
            }
        }


        // Simpan polling baru
        $polling = new Polling;
        $polling->title = $request->title;
        $polling->user_id = $user->id;
        $polling->is_foto = true;
        $polling->save();

        // Simpan opsi/jawaban berupa foto
        foreach ($request->option as $photo) {
            // Proses upload foto
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads'), $photoName); // Simpan di folder uploads

            // Simpan path foto di database
            $jawaban = new Jawaban;
            $jawaban->polling_id = $polling->id;
            $jawaban->option = 'uploads/' . $photoName; // Path foto yang disimpan
            $jawaban->save();
        }

        return redirect()->route('polling.show', $polling->id)->with('success', 'Polling foto berhasil dibuat!');
    }





    // Menampilkan detail polling berdasarkan ID
    public function show(string $id)
    {
        $polling = Polling::findOrFail($id);

        if ($polling->ditutup) {
            return redirect()->route('polling.create')->with('error', 'Polling ini sudah ditutup dan tidak bisa diakses.');
        }

        return view('Polling.show', ['polling' => $polling]);
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
            $polling = Polling::where('ditutup', false)
                ->orderBy('created_at', 'desc')
                ->get();
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


    public function hapus($id)
    {
        $polling = Polling::findOrFail($id); // Cari polling berdasarkan ID

        // Pastikan hanya user yang membuat polling atau admin yang bisa menghapusnya
        if (Auth::id() !== $polling->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus polling ini.');
        }

        // Hapus polling dan semua jawaban yang terkait
        $polling->jawaban()->delete(); // Jika ada jawaban terkait, hapus dulu
        $polling->delete(); // Hapus polling

        return redirect()->back()->with('success', 'Polling berhasil dihapus.');
    }

    public function tutup($id)
    {
        $polling = Polling::findOrFail($id);

        // Pastikan user yang menutup adalah pembuat polling
        if (Auth::id() !== $polling->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menutup polling ini.');
        }

        // Tutup Buka polling
        if ($polling->ditutup == true) {
            $polling->ditutup = false;
            $polling->save();
            session()->flash('success', 'Polling berhasil dibuka kembali.');
        } else {
            $polling->ditutup = true;
            $polling->save();
            session()->flash('success', 'Polling berhasil ditutup.');
        }

        return redirect()->back();
    }
}
