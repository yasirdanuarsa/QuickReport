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
          <th>Status</th>
          <th>Petugas</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($laporans as $laporan)
          <tr>
            <td>{{ ($laporans->currentPage() - 1) * $laporans->perPage() + $loop->iteration }}</td>
            <td>{{ ucfirst($laporan->report_type) }}</td>
            <td>{{ $laporan->tanggal_laporan }}</td>
            <td>{{ $laporan->perihal }}</td>
            <td>{{ $laporan->instansi }}</td>
            <td>
              <span class="badge bg-{{ $laporan->status == 'selesai' ? 'success' : 'warning' }}">
                {{ ucfirst($laporan->status) }}
              </span>
            </td>
            <td>{{ $laporan->petugas->name ?? '-' }}</td>
            <td>
              <div class="d-flex flex-wrap gap-1">
                <a href="{{ route('monev.show', $laporan->id) }}" class="btn btn-sm btn-info">Detail</a>
                <a href="{{ route('monev.edit', $laporan->id) }}" class="btn btn-sm btn-primary">Edit</a>
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
    <div class="d-flex justify-content-center mt-3">
      {{ $laporans->links() }}
  </div>
  </div>
</div>
@endsection
