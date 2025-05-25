@extends('admin.admin')

@section('extend')
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-warning text-dark fw-bold">
      <h4 class="mb-0">Perpanjang Deadline Laporan</h4>
    </div>
    <div class="card-body">

      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      <form method="POST" action="{{ route('monev.extendDeadline', $laporan->id) }}">
        @csrf
        @method('POST')

        <div class="mb-3">
          <label class="form-label">Instansi</label>
          <input type="text" class="form-control" value="{{ $laporan->instansi }}" disabled>
        </div>

        <div class="mb-3">
          <label class="form-label">Perihal</label>
          <input type="text" class="form-control" value="{{ $laporan->perihal }}" disabled>
        </div>

        <div class="mb-3">
          <label class="form-label">Deadline Sebelumnya</label>
          <input type="text" class="form-control" value="{{ $laporan->deadline ? \Carbon\Carbon::parse($laporan->deadline)->translatedFormat('d F Y') : '-' }}" disabled>
        </div>

        <div class="mb-3">
          <label for="deadline" class="form-label">Deadline Baru</label>
          <input type="date" name="deadline" class="form-control" required min="{{ now()->toDateString() }}">
        </div>

        <div class="d-flex justify-content-between">
          <a href="{{ route('monev.index') }}" class="btn btn-secondary">← Kembali</a>
          <button type="submit" class="btn btn-warning">Perpanjang Deadline</button>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection
