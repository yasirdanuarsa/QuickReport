<!DOCTYPE html>
<html>
<head>
    <title>Print Data Monev</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- optional, styling --}}
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h2>Data Monitoring Evaluasi</h2>

    <button onclick="window.print()">Print</button>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Laporan</th>
                <th>Tanggal Laporan</th>
                <th>Perihal</th>
                <th>Instansi</th>
                <th>Status</th>
                <th>Petugas</th>
                <th>Hasil</th>
                <th>Bukti</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
            <tr>
                <td>{{ ($laporans->currentPage() - 1) * $laporans->perPage() + $loop->iteration }}</td>
                <td>{{ ucfirst($item->report_type) }}</td>
                <td>{{ $item->tanggal_laporan }}</td>
                <td>{{ $item->perihal }}</td>
                <td>{{ $item->instansi }}</td>
                <td>
                  <span class="badge bg-{{ $item->status == 'selesai' ? 'success' : 'warning' }}">
                    {{ ucfirst($item->status) }}
                  </span>
                </td>
                <td>{{ $item->petugas->name ?? '-' }}</td>
                <td>{{ $item->hasil }}</td>
                <td><img src="{{ asset('storage/' . $item->bukti) }}" width="100"></td>
                <td>{{ $item->created_at->format('d-m-Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
