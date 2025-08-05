<?php

namespace App\Http\Controllers\Admin;

use App\Models\Crud;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
// use Dompdf\Dompdf;

class MonevController extends Controller
{
    // Menampilkan laporan dengan filter
    public function index(Request $request)
    {
        $query = Crud::with('petugas');
    
        if ($request->filled('kegiatan')) {
            $query->where('instansi', 'like', '%' . $request->kegiatan . '%');
        }
    
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_laporan', $request->tanggal);
        }
        
        $laporans = $query->orderBy('tanggal_laporan', 'desc')->paginate(20); // ← Pagination 10 data per halaman
       // Ambil data untuk chart bulanan
        $laporanBulanan = Crud::selectRaw('MONTH(tanggal_laporan) as bulan, COUNT(*) as total')
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan')
        ->mapWithKeys(function ($val, $key) {
            return [\Carbon\Carbon::create()->month($key)->locale('id')->monthName => $val];
        });

        // Ambil data untuk chart harian (7 hari terakhir)
        $laporanHarian = Crud::selectRaw('DATE(tanggal_laporan) as tanggal, COUNT(*) as total')
        ->where('tanggal_laporan', '>=', now()->subDays(6))
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->pluck('total', 'tanggal')
        ->mapWithKeys(function ($val, $key) {
            return [\Carbon\Carbon::parse($key)->locale('id')->translatedFormat('d M') => $val];
        }); 
        $statusCounts = [
        'Pending' => $laporans->where('status', 'pending')->count(),
        'Selesai' => $laporans->where('status', 'selesai')->count()
        ];
        // Ambil jumlah laporan selesai per petugas
        // Ambil data selesai dan pending per petugas
    $laporanPerPetugas = DB::table('cruds')
        ->join('users', 'cruds.users_id', '=', 'users.id')
        ->select('users.name',
            DB::raw("SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as selesai"),
            DB::raw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending")
        )
        ->groupBy('users.name')
        ->get();

    // Buat struktur data untuk chart
    $petugasNames = $laporanPerPetugas->pluck('name');
    $selesaiCounts = $laporanPerPetugas->pluck('selesai');
    $pendingCounts = $laporanPerPetugas->pluck('pending');

    return view('admin.products.index', compact(
        'laporans', 'laporanBulanan', 'laporanHarian', 'statusCounts',
        'petugasNames', 'selesaiCounts', 'pendingCounts'
    ));
       
        
    }

    /**
     * Tampilkan form input laporan
     */
    public function create()
    {
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.products.crud', compact('petugas'));
    }

    /**
     * Simpan data laporan ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:surat_masuk,telepon',
            'activity' => 'required|string|max:255',
            'tanggal_laporan' => 'required|date',
            'perihal' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'petugas_id' => 'required|exists:users,id',
            'surat_masuk_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'nomor_telepon' => 'nullable|string|max:20',
            'deadline' => 'required|date',
        ]);

        // Simpan file jika ada
        $suratPath = null;
        if ($request->hasFile('surat_masuk_file')) {
            $suratPath = $request->file('surat_masuk_file')->store('surat_masuk', 'public');
        }

        // Simpan ke database
        Crud::create([
            'report_type' => $request->report_type,
            'surat_masuk_path' => $suratPath,
            'nomor_telepon' => $request->nomor_telepon,
            'activity' => $request->activity,
            'tanggal_laporan' => $request->tanggal_laporan,
            'perihal' => $request->perihal,
            'instansi' => $request->instansi,
            'status' => 'pending', // default
            'users_id' => $request->petugas_id,
            'deadline' => $request->deadline,
        ]);


        return redirect()->route('monev.create')->with('success', 'Laporan berhasil disimpan!');
    }
    
        

    // Mengedit laporan
    public function edit($id)
    {
        $laporan = Crud::findOrFail($id);
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.products.edit', compact('laporan', 'petugas'));
    }



    // Memperbarui laporan
    public function update(Request $request, $id)
    {
        $laporan = Crud::findOrFail($id);
    
        $validated = $request->validate([
            'report_type' => 'required|in:surat_masuk,telepon',
            'activity' => 'required|string|max:255',
            'tanggal_laporan' => 'required|date',
            'perihal' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'status' => 'required|in:pending,selesai',
            'petugas_id' => 'required|exists:users,id',
            'surat_masuk_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'nomor_telepon' => 'nullable|string|max:20',
            'bukti' => 'nullable|image|max:2048',
            'hasil' => 'nullable|string',
            'deadline' => 'required|date',

        ]);
    
        // File baru jika ada
        if ($request->hasFile('surat_masuk_file')) {
            $validated['surat_masuk_path'] = $request->file('surat_masuk_file')->store('surat_masuk', 'public');
        }
        if ($request->hasFile('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('bukti', 'public');
        }
        
    
        $validated['users_id'] = $validated['petugas_id'];
        unset($validated['petugas_id']);
    
        $laporan->update($validated);
    
        return redirect()->route('monev.index')->with('success', 'Laporan berhasil diperbarui!');
    }
    // Mencetak laporan
    
    public function print(Request $request)
    {
        $query = Crud::query();
    
        if ($request->filled('kegiatan')) {
            $query->where('kegiatan', 'like', '%' . $request->kegiatan . '%');
        }
    
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }
        $laporans = $query->orderBy('tanggal_laporan', 'desc')->paginate(); 
        $laporan = $query->orderBy('tanggal_laporan', 'desc')->paginate();
        $data = $query->latest()->get();
    
        return view('admin.products.print', compact('data', 'laporans', 'laporan'));
    }

    // Menampilkan laporan
    public function reports()
    {
        $query = Crud::with('petugas');
        $data = Crud::with('petugas')->get(); 
        $data = Crud::orderBy('tanggal_laporan', 'desc')->get();
        $title = 'Laporan Kegiatan';
        $laporan = $query->orderBy('tanggal_laporan', 'desc')->paginate(10); // ← Pagination 10 data per halaman
    
        return view('reports', compact('data', 'title', 'laporan'));
        
    }
    

    // Menampilkan detail laporan
    public function show($id)
    {
        $laporan = Crud::with('petugas')->findOrFail($id);
        return view('admin.products.show', compact('laporan'));
    }
    
    

    // Memperbarui status laporan
    public function updateStatus(Request $request, $id)
    {
        $laporan = Crud::findOrFail($id);
        $laporan->status = $request->status;
        $laporan->save();

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui!');
    }

    public function report(Request $request)
    {
        $query = Crud::query();
    
        // Filter berdasarkan kegiatan
        if ($request->filled('kegiatan')) {
            $query->where('kegiatan', 'like', '%' . $request->kegiatan . '%');
        }
    
        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }
    
        $data = $query->latest()->get();
    
        // Ambil daftar petugas dari database
        $petugas = User::all(); // Mengambil semua data petugas
    
        return view('admin.products.crud', compact('data', 'petugas')); // Kirim $petugas ke view
    }
    public function exportCsv(Request $request)
    {
        $data = Crud::with('petugas'); // Removed ->query() as it's unnecessary
        
        if ($request->filled('kegiatan')) {
            $data->where('kegiatan', 'like', '%'.$request->kegiatan.'%');
        }
        if ($request->filled('tanggal')) {
            $data->whereDate('created_at', $request->tanggal);
        }
    
        $fileName = 'report-'.now()->format('Y-m-d').'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];
    
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID', 'Jenis Laporan', 'Tanggal', 'Perihal', 
                'Instansi', 'Status', 'Petugas', 'Nomor Telepon'
            ]);
    
            // Add data rows
            foreach ($data->get() as $report) {
                fputcsv($file, [
                    $report->id,
                    $report->jenis_laporan,
                    $report->tanggal_laporan,
                    $report->perihal,
                    $report->instansi,
                    $report->status,
                    $report->petugas->name ?? '',
                    $report->nomor_telepon
                ]);
            }
            
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    public function destroy($id)
    {
        $laporan = Crud::findOrFail($id);
        $laporan->delete();
    
        return redirect()->route('monev.index')->with('success', 'Laporan berhasil dihapus!');
    }
    
    public function dashboard()
    {
        $petugas = Auth::user();
    
        if ($petugas->role === 'admin') {
            // data khusus admin
            return view('admin.admin');
        } else {
            // data khusus petugas
            return view('petugas.layouts');
        }
        // Ambil data laporan per bulan & tahun
    $laporanPerBulan = Crud::table('laporans')
        ->select(Crud::raw('MONTH(created_at) as bulan'), Crud::raw('count(*) as total'))
        ->groupBy('bulan')
        ->pluck('total', 'bulan');

    $laporanPerTahun = Crud::table('laporans')
        ->select(Crud::raw('YEAR(created_at) as tahun'), Crud::raw('count(*) as total'))
        ->groupBy('tahun')
        ->pluck('total', 'tahun');

    // Kriteria lain (jenis laporan, aktivitas, status, petugas)
    $byJenis = Crud::table('laporans')->select('jenis', Crud::raw('count(*) as total'))->groupBy('jenis')->pluck('total', 'jenis');
    $byAktivitas = Crud::table('laporans')->select('aktivitas', Crud::raw('count(*) as total'))->groupBy('aktivitas')->pluck('total', 'aktivitas');
    $byStatus = Crud::table('laporans')->select('status', Crud::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status');
    $byPetugas = Crud::table('laporans')->select('petugas_id', Crud::raw('count(*) as total'))->groupBy('petugas_id')->pluck('total', 'petugas_id');

    return view($user->role === 'admin' ? 'dashboard-admin' : 'dashboard-petugas', compact(
        'laporanPerBulan',
        'laporanPerTahun',
        'byJenis',
        'byAktivitas',
        'byStatus',
        'byPetugas'
    ));
    }
    public function extendForm($id)
    {
    $laporan = Crud::findOrFail($id);
    return view('admin.products.extend', compact('laporan'));
    }

    public function extendDeadline(Request $request, $id)
    {
    $request->validate(['deadline' => 'required|date|after:today']);
    
    $laporan = Crud::findOrFail($id);
    $laporan->deadline = $request->deadline;
    $laporan->notified = false;
    $laporan->save();

    return redirect()->route('monev.index')->with('success', 'Deadline berhasil diperpanjang.');
    }
    

}