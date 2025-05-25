@extends('petugas.layouts')

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Data Monev</h1>
  </div>
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </div>
</div>
@endsection
{{-- @section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Common chart options
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    font: { size: 14 },
                    color: '#333'
                }
            },
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(0,0,0,0.7)'
            }
        }
    };

    // Chart Bulanan
    const ctxBulanan = document.getElementById('chartBulanan').getContext('2d');
    new Chart(ctxBulanan, {
        type: 'bar',
        data: {
            labels: @json($laporanBulanan->keys()),
            datasets: [{
                label: 'Jumlah Laporan Per Bulan',
                data: @json($laporanBulanan->values()),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderRadius: 8
            }]
        },
        options: commonOptions
    });

    // Chart Harian
    const ctxHarian = document.getElementById('chartHarian').getContext('2d');
    new Chart(ctxHarian, {
        type: 'line',
        data: {
            labels: @json($laporanHarian->keys()),
            datasets: [{
                label: 'Jumlah Laporan Harian',
                data: @json($laporanHarian->values()),
                borderColor: 'rgba(255, 99, 132, 0.8)',
                backgroundColor: 'rgba(255, 99, 132, 0.3)',
                fill: true,
                tension: 0.4
            }]
        },
        options: commonOptions
    });

    // Chart Status (Pending vs Selesai)
    const ctxStatus = document.getElementById('chartStatus').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($statusCounts)),
            datasets: [{
                label: 'Status Laporan',
                data: @json(array_values($statusCounts)),
                backgroundColor: ['rgba(255, 206, 86, 0.8)', 'rgba(75, 192, 192, 0.8)'],
                borderColor: ['#f1c40f', '#2ecc71'],
                borderWidth: 1
            }]
        },
        options: {
            ...commonOptions,
            cutout: '65%' // buat jadi doughnut
        }
    });
</script>
@endsection --}}

@section('content')
<div class="container mt-4">
  <h4>Dashboard Petugas</h4>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Jenis Laporan</th>
          <th>Tanggal Laporan</th>
          <th>Perihal</th>
          <th>Instansi</th>
          <th>Status</th>
          <th>Deadline</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($laporans as $laporan)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ ucfirst($laporan->report_type) }}</td>
            <td>{{ $laporan->tanggal_laporan }}</td>
            <td>{{ $laporan->perihal }}</td>
            <td>{{ $laporan->instansi }}</td>
            <td>
              <span class="badge bg-{{ $laporan->status === 'selesai' ? 'success' : 'warning' }}">
                {{ ucfirst($laporan->status) }}
              </span>
            </td>
            <td>
              <small class="text-muted">
                {{ $laporan->deadline ? \Carbon\Carbon::parse($laporan->deadline)->locale('id')->translatedFormat('d F Y') : '-' }}
              </small>
            </td>
            <td>
              <a href="{{ route('petugas.laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">Detail</a>
              <a href="{{ route('petugas.laporan.edit', $laporan->id) }}" class="btn btn-sm btn-primary">Edit</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
