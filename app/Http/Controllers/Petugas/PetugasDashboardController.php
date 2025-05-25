<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Crud;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PetugasDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $laporans = Crud::where('users_id', $user->id)->latest()->paginate(10);

        // Diagram untuk laporan bulanan
        $laporanBulanan = Crud::selectRaw('MONTH(tanggal_laporan) as bulan, COUNT(*) as total')
            ->where('users_id', $user->id)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->mapWithKeys(function ($val, $key) {
                return [\Carbon\Carbon::create()->month($key)->locale('id')->monthName => $val];
            });

        // Diagram untuk laporan harian (7 hari terakhir)
        $laporanHarian = Crud::selectRaw('DATE(tanggal_laporan) as tanggal, COUNT(*) as total')
            ->where('users_id', $user->id)
            ->where('tanggal_laporan', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal')
            ->mapWithKeys(function ($val, $key) {
                return [\Carbon\Carbon::parse($key)->locale('id')->translatedFormat('d M') => $val];
            });

        return view('petugas.dashboard', compact('laporans', 'laporanBulanan', 'laporanHarian'));
    }

    public function show($id)
    {
        $laporan = Crud::with('petugas')->findOrFail($id);
        return view('petugas.laporan.show', compact('laporan'));
    }

    public function edit($id)
    {
        $laporan = Crud::findOrFail($id);
        return view('petugas.laporan.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Crud::findOrFail($id);

        $validated = $request->validate([
            'activity' => 'required',
            'tanggal_laporan' => 'required|date',
            'perihal' => 'required',
            'instansi' => 'required',
            'hasil' => 'nullable',
            'bukti' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('bukti', 'public');
        }

        $laporan->update($validated);
        return redirect()->route('petugas.dashboard')->with('success', 'Laporan berhasil diperbarui.');
    }
}
