<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Polling;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PollingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
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

        $polling = new Polling;
        $polling->title = $request->title;
        $polling->save();

        foreach ($request->option as $option) {
            $jawaban = new Jawaban;
            $jawaban->polling_id = $polling->id;
            $jawaban->option = $option;
            $jawaban->save();
        }

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
