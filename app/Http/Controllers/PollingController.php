<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Polling;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;

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
        // $option = $request->option;
        // $serializeOption = serialize($option);

        $maxPolling = 3;

        // Ambil jumlah polling dari cookie, default 0 jika belum ada cookie
        $statusPolling = Cookie::get('polls_count', 0);

        // Ambil tanggal terakhir kali polling dibuat dari cookie
        $terakhirPolling = Cookie::get('last_poll_date');

        // Cek apakah polling terakhir dibuat bukan hari ini
        if ($terakhirPolling && Carbon::parse($terakhirPolling)->isToday() == false) {
            $statusPolling = 0; // Reset counter jika polling terakhir dibuat bukan hari ini
        }

        // Cek apakah user sudah mencapai batas maksimal polling per hari
        if ($statusPolling >= $maxPolling) {
            return back()->with('error', 'Anda telah mencapai batas maksimal polling hari ini.');
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

        // update cookie
        Cookie::queue('polls_count', ++$statusPolling, 1440); // 1440 menit = 1 hari
        Cookie::queue('last_poll_date', Carbon::now()->toDateString(), 1440);


        // $polling->option = $serializeOption;

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
