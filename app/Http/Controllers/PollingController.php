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
    public function create()
    {
        return view('Polling.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:5',
            'option' => 'required|array', // Pastikan 'option' adalah array
            'option.*' => 'required|string', // Pastikan setiap elemen dalam array 'option' adalah string yang diperlukan
        ]);
        $maxPolling = 3; // Batas maksimal polling per hari
        $ipAddress = $request->ip(); // Ambil alamat IP pengguna
        $batasPolling = BatasPolling::where('ip_address', $ipAddress)->first(); // Cek apakah sudah ada entry untuk IP ini

        // Cek apakah sudah ada entry untuk IP ini
        if ($batasPolling) {
            // Reset jika sudah sehari
            if ($batasPolling->tanggal_polling && Carbon::parse($batasPolling->tanggal_polling)->isToday() == false) {
                $batasPolling->jumlah_polling = 0;
                $batasPolling->tanggal_polling = null;
            }

            // Cek batas polling
            if ($batasPolling->jumlah_polling >= $maxPolling) {
                return back()->with('error', 'Anda telah mencapai batas maksimal polling hari ini.');
            }

            // Update jumlah polling
            $batasPolling->jumlah_polling++;
            $batasPolling->tanggal_polling = Carbon::now()->toDateString(); // Simpan tanggal hari ini
            $batasPolling->save(); // Simpan perubahan ke database
        } else {
            // Jika belum ada, buat entri baru

            $batasPolling = new BatasPolling;
            $batasPolling->ip_address = $ipAddress;
            $batasPolling->jumlah_polling = 1;
            $batasPolling->tanggal_polling = Carbon::now()->toDateString(); // Simpan tanggal hari ini
            $batasPolling->save();
        }


        $polling = new Polling;
        $polling->title = $request->title;
        $polling->ip_address = $ipAddress;
        $polling->save();

        foreach ($request->option as $option) {
            $jawaban = new Jawaban;
            $jawaban->polling_id = $polling->id;
            $jawaban->option = $option;
            $jawaban->save();
        }
        return redirect()->route('polling.show', $polling->id);
    }

    public function show(string $id)
    {
        $polling = Polling::findOrFail($id);

        return view('Polling.show', ['polling' => $polling]);
    }


    public function vote(Request $request, $id)
    {
        $validated = $request->validate([
            'jawaban_id' => 'required|exists:jawabans,id',
        ]);
        $ipAddress = $request->ip(); // Tangkap IP pengguna

        // Ambil polling terkait jawaban_id
        $pollingId = Jawaban::where('id', $request->jawaban_id)->value('polling_id');

        // Cek apakah IP sudah pernah vote untuk polling ini
        $existingVote = Vote::where('polling_id', $pollingId)
            ->where('ip_address', $ipAddress)
            ->first();

        if ($existingVote) {
            // Jika sudah vote, berikan feedback dan redirect
            return redirect()->route('polling.show', $pollingId)->with('error', 'Anda sudah melakukan vote.');
        }

        //menambah jumlah vote
        $jawaban = Jawaban::findOrFail($request->jawaban_id);
        $jawaban->vote += 1;
        $jawaban->save();;

        //simpan ip_address ke table votes
        $vote = new Vote;
        $vote->polling_id = $pollingId;
        $vote->ip_address = $ipAddress;
        $vote->save();

        //mengambil model polling berdasarkan id, id yang di kirim di form melalui input type hiiden
        $pollingId = Polling::findOrFail($request->polling_id);
        return redirect()->route('polling.showStatus', $pollingId->id);
    }

    public function showStatus($id)
    {
        $polling = Polling::findOrFail($id);
        return view('Polling.showStatus', ['polling' => $polling]);
    }

    public function showPolling($id)
    {
        $polling = Polling::findOrFail($id);
        return view('Polling.showPolling', ['polling' => $polling]);
    }


    public function pollingTersimpan(Request $request)
    {
        $ip = $request->ip();
        // tangkap ip address
        $polling = Polling::where('ip_address', $ip)->get();
        return view('Polling.pollingTersimpan', [
            'pollings' => $polling
        ]);
    }

    public function tentang()
    {
        return view('polling.tentang');
    }

    public function destroy($id)
    {
        $polling = Polling::findOrFail($id);
        $polling->delete();
        return redirect()->route('polling.pollingTersimpan');
    }
}
