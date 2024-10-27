<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BatasPolling;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('Admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function statistik()
    {
        $filteredUsers = User::select('id', 'email', 'ip_address')->get()->filter(fn($user) => !$user->hasRole('admin'));
        $batas_polling = BatasPolling::select('jumlah_polling')->get();

        return view('Admin.statistik', compact('filteredUsers', 'batas_polling'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
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
    public function hapus(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.statistik')->with('success', 'User berhasil dihapus !');
    }
}
