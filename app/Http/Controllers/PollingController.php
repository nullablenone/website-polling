<?php

namespace App\Http\Controllers;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'option' => 'required|array', // Pastikan 'option' adalah array
            'option.*' => 'required|string', // Pastikan setiap elemen dalam array 'option' adalah string yang diperlukan
        ]);
        $maxPolling = 3; // Batas maksimal polling per hari
        $ipAddress = $request->ip(); // Ambil alamat IP pengguna
        $pollingLimit = BatasPolling::where('ip_address', $ipAddress)->first(); // Cek apakah sudah ada entry untuk IP ini

        // Cek apakah sudah ada entry untuk IP ini
        if ($pollingLimit) {
            // Reset jika sudah sehari
            if ($pollingLimit->tanggal_polling && Carbon::parse($pollingLimit->tanggal_polling)->isToday() == false) {
                $pollingLimit->jumlah_polling = 0; // Reset counter jika polling terakhir tidak dibuat hari ini
                $pollingLimit->tanggal_polling = null; // Reset tanggal
            }

            // Cek batas polling
            if ($pollingLimit->jumlah_polling >= $maxPolling) {
                return back()->with('error', 'Anda telah mencapai batas maksimal polling hari ini.');
            }

            // Update jumlah polling
            $pollingLimit->jumlah_polling++;
            $pollingLimit->tanggal_polling = Carbon::now()->toDateString(); // Simpan tanggal hari ini
            $pollingLimit->save(); // Simpan perubahan ke database
        } else {
            // Jika belum ada, buat entri baru
            BatasPolling::create([
                'ip_address' => $ipAddress,
                'jumlah_polling' => 1,
                'tanggal_polling' => Carbon::now()->toDateString(), // Simpan tanggal hari ini
            ]);
        }


        $polling = new Polling;
        $polling->title = $request->title;
        $polling->save();

        foreach ($request->option as $option) {
            $jawaban = new Jawaban;
            $jawaban->polling_id = $polling->id;
            $jawaban->option = $option;
            $jawaban->save();
        }

        return redirect()->route('polling.show', $polling->id)->with('success', 'Polling berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $polling = Polling::findOrFail($id);

        return view('Polling.show', ['polling' => $polling]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function vote(Request $request, $id)
    {
        $validated = $request->validate([
            'jawaban_id' => 'required|exists:jawabans,id',
        ]);

        //menambah jumlah vote
        $jawaban = Jawaban::findOrFail($request->jawaban_id);
        $jawaban->vote += 1;
        $jawaban->save();;

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

    /**
     * Update the specified resource in storage.
     */
    public function pollingTersimpan()
    {
        $polling = Polling::get();
        return view('Polling.pollingTersimpan', [
            'pollings' => $polling
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
