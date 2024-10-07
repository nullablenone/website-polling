<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Jawaban;
use App\Models\Polling;
use App\Models\BatasPolling;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;

class PollingController extends Controller
{

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
            'title' => 'required|min:5', // Judul polling harus ada dan minimal 5 karakter
            'option' => 'required|array', // Opsi polling harus berupa array
            'option.*' => 'required|string', // Setiap elemen di array option harus berupa string
        ]);


        $maxPolling = 10; // Batas maksimal polling yang bisa dibuat per hari

        $ipAddress = $request->ip(); // Mendapatkan IP address pengguna

        // Cek apakah IP pengguna sudah ada di tabel batas polling
        $batasPolling = BatasPolling::where('ip_address', $ipAddress)->first();


        // Jika ada entry dengan IP yang sama
        if ($batasPolling) {
            // Reset polling jika sudah berganti hari
            if ($batasPolling->tanggal_polling && Carbon::parse($batasPolling->tanggal_polling)->isToday() == false) {
                $batasPolling->jumlah_polling = 0; // Reset jumlah polling ke 0
                $batasPolling->tanggal_polling = null; // Reset tanggal polling
            }


            // Jika jumlah polling sudah mencapai batas harian
            if ($batasPolling->jumlah_polling >= $maxPolling) {
                return back()->with('error', 'Anda telah mencapai batas maksimal polling hari ini.');
            }


            // Jika belum mencapai batas, update jumlah polling dan simpan ke database
            $batasPolling->jumlah_polling++;
            $batasPolling->tanggal_polling = Carbon::now()->toDateString(); // Simpan tanggal polling hari ini
            $batasPolling->save(); // Update entry di database

        } else {
            // Jika belum ada entry untuk IP ini, buat yang baru
            $batasPolling = new BatasPolling;
            $batasPolling->ip_address = $ipAddress; // Simpan IP address pengguna
            $batasPolling->jumlah_polling = 1; // Set polling pertama
            $batasPolling->tanggal_polling = Carbon::now()->toDateString(); // Simpan tanggal polling hari ini
            $batasPolling->save(); // Simpan entry baru ke database
        }


        // Membuat polling baru dan menyimpan ke database
        $polling = new Polling;
        $polling->title = $request->title; // Set title polling
        $polling->ip_address = $ipAddress; // Simpan IP address pembuat polling
        $polling->save(); // Simpan polling ke database


        // Simpan setiap opsi/jawaban ke tabel 'jawaban'
        foreach ($request->option as $option) {
            $jawaban = new Jawaban;
            $jawaban->polling_id = $polling->id; // Hubungkan jawaban dengan polling
            $jawaban->option = $option; // Set opsi/jawaban
            $jawaban->save(); // Simpan jawaban ke database
        }

        // Redirect ke halaman polling yang baru dibuat
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
        $polling = Polling::orderBy('created_at', 'desc')->get();
        return view('Polling.pollingTerbaru', [
            'pollings' => $polling //kirim polling yang sudah di urutkan
        ]);
    }


    // Menampilkan halaman "tentang"
    public function tentang()
    {
        return view('polling.tentang');
    }


    // Menghapus polling berdasarkan ID
    public function destroy($id)
    {
        $polling = Polling::findOrFail($id); // Ambil polling dari database berdasarkan ID
        $polling->delete(); // Hapus polling
        return redirect()->route('polling.pollingTerbaru')->with('success', 'Polling berhasil di hapus.');
    }
}
