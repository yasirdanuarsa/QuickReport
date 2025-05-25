@extends('petugas.layouts')

@section('content')
<div class="container mt-4">
  <h4>Edit Laporan</h4>
  <form method="POST" action="{{ route('petugas.laporan.update', $laporan->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="activity" class="form-label">Aktivitas</label>
      <input type="text" class="form-control" name="activity" value="{{ $laporan->activity }}" required>
    </div>

    <div class="mb-3">
      <label for="tanggal_laporan" class="form-label">Tanggal</label>
      <input type="date" class="form-control" name="tanggal_laporan" value="{{ $laporan->tanggal_laporan }}" required>
    </div>

    <div class="mb-3">
      <label for="perihal" class="form-label">Perihal</label>
      <input type="text" class="form-control" name="perihal" value="{{ $laporan->perihal }}" required>
    </div>

    <div class="mb-3">
      <label for="instansi" class="form-label">Instansi</label>
      <input type="text" class="form-control" name="instansi" value="{{ $laporan->instansi }}" required>
    </div>

    <div class="mb-3">
      <label for="hasil" class="form-label">Hasil</label>
      <textarea name="hasil" class="form-control" rows="4">{{ $laporan->hasil }}</textarea>
    </div>

    <div class="mb-3">
      <label for="bukti" class="form-label">Upload Bukti (Opsional)</label>
      <input type="file" class="form-control" name="bukti">
      @if($laporan->bukti)
        <small class="d-block mt-2">Bukti lama: <img src="{{ asset('storage/' . $laporan->bukti) }}" width="150"></small>
      @endif
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
