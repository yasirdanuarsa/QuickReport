@extends('admin.admin')

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
@include('admin.components.tabel')
@section('scripts')
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
// Chart: Laporan per Petugas (Selesai vs Pending)
const ctxPetugas = document.getElementById('chartLaporanPetugas').getContext('2d');
new Chart(ctxPetugas, {
    type: 'bar',
    data: {
        labels: @json($petugasNames),
        datasets: [
            {
                label: 'Selesai',
                data: @json($selesaiCounts),
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                borderRadius: 6
            },
            {
                label: 'Pending',
                data: @json($pendingCounts),
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                borderRadius: 6
            }
        ]
    },
    options: {
        ...commonOptions,
        responsive: true,
        plugins: {
            title: {
                display: false
            },
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

</script>


@endsection



@section('content')
<div class="container mt-4">

  {{-- Alert --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  

  {{-- Filter --}}
  <form method="GET" action="{{ route('monev.index') }}" class="mb-3">
    <div class="d-flex flex-wrap gap-2">
      <input type="text" name="kegiatan" value="{{ request('kegiatan') }}" placeholder="Cari instansi..." class="form-control" style="max-width: 200px;">
      <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control" style="max-width: 200px;">
      <button type="submit" class="btn btn-primary">Cari</button>
      <a href="{{ route('monev.index') }}" class="btn btn-secondary">Reset</a>
    </div>
  </form>

  {{-- Export / Print --}}
  <div class="d-flex gap-2 mb-4">
    <form method="GET" action="{{ route('monev.export.csv') }}">
      <input type="hidden" name="kegiatan" value="{{ request('kegiatan') }}">
      <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
      <button type="submit" class="btn btn-info">
        <i class="fas fa-file-csv"></i> Export CSV
      </button>
    </form>

    <form method="GET" action="{{ route('monev.print') }}" target="_blank">
      <input type="hidden" name="kegiatan" value="{{ request('kegiatan') }}">
      <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
      <button type="submit" class="btn btn-success">
        <i class="fas fa-print"></i> Print
      </button>
    </form>
  </div>

  {{-- Tabel Data --}}
  <div class="table-responsive">
    <table class="table table-bordered align-middle">    
      <thead class="table-light text-center">
        <tr>
          <th>No</th>
          <th>Jenis Laporan</th>
          <th>Tanggal Laporan</th>
          <th>Perihal</th>
          <th>Instansi</th>
          <th>Status/Deadline</th>
          <th>Petugas</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($laporans as $laporan)
          @php
            $isOverdue = $laporan->deadline && \Carbon\Carbon::parse($laporan->deadline)->isPast();
          @endphp
          <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
            <td>{{ ($laporans->currentPage() - 1) * $laporans->perPage() + $loop->iteration }}</td>
            <td>{{ ucfirst($laporan->report_type) }}</td>
            <td>{{ $laporan->tanggal_laporan }}</td>
            <td>{{ $laporan->perihal }}</td>
            <td>{{ $laporan->instansi }}</td>
           <td class="text-center">
            <span class="badge bg-{{ $laporan->status == 'selesai' ? 'success' : 'warning' }}">
               {{ ucfirst($laporan->status) }}
            </span>
            <br>
            @php
              $isOverdue = $laporan->deadline && \Carbon\Carbon::parse($laporan->deadline)->isPast();
            @endphp
          <small class="{{ $isOverdue ? 'text-danger fw-bold' : 'text-muted' }}" title="{{ $isOverdue ? 'Deadline sudah lewat' : 'Masih dalam batas waktu' }}">
            @if($isOverdue)
              <i class="fas fa-exclamation-triangle me-1"></i>
            @endif
            {{ $laporan->deadline ? \Carbon\Carbon::parse($laporan->deadline)->locale('id')->translatedFormat('l, d F Y') : '-' }}
          </small>
            <td>{{ $laporan->petugas->name ?? '-' }}</td>
          <td>
            <div class="d-flex flex-wrap gap-1">
              <a href="{{ route('monev.show', $laporan->id) }}" class="btn btn-sm btn-info">Detail</a>
              <a href="{{ route('monev.edit', $laporan->id) }}" class="btn btn-sm btn-primary">Edit</a>
    
              {{-- Tombol Perpanjang Deadline --}}
              <a href="{{ route('monev.extendDeadline', $laporan->id) }}"
              class="btn btn-sm text-white"
              style="background: linear-gradient(to right, #f39c12, #f1c40f); font-size: 0.75rem; padding: 4px 8px; border-radius: 4px;">
              <i class="fas fa-clock"></i> Perpanjang</a>

              <form action="{{ route('monev.destroy', $laporan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
              @csrf
              @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
           </div>
          </td>          
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center text-muted">Belum ada data laporan.</td>
          </tr>
        @endforelse
      </tbody>    
    </table>
    {{-- <div class="d-flex justify-content-center mt-3">
      {{ $laporans->links(admin.vendor.pagination.tailwind) }}
  </div> --}}
  </div>
</div>
@endsection
