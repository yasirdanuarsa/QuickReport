@extends('petugas.layouts')

@section('content')
<div class="container mt-4">
  <h4>Detail Laporan</h4>
  <ul class="list-group">
    <li class="list-group-item"><strong>Jenis Laporan:</strong> {{ ucfirst($laporan->report_type) }}</li>
    <li class="list-group-item"><strong>Tanggal:</strong> {{ $laporan->tanggal_laporan }}</li>
    <li class="list-group-item"><strong>Perihal:</strong> {{ $laporan->perihal }}</li>
    <li class="list-group-item"><strong>Instansi:</strong> {{ $laporan->instansi }}</li>
    <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($laporan->status) }}</li>
    <li class="list-group-item"><strong>Deadline:</strong> {{ $laporan->deadline }}</li>
    <li class="list-group-item"><strong>Hasil:</strong> {{ $laporan->hasil }}</li>
    <li class="list-group-item">
      <strong>Bukti:</strong><br>
      @if($laporan->bukti)
        <img src="{{ asset('storage/' . $laporan->bukti) }}" width="200">
      @else
        Tidak ada bukti
      @endif
    </li>
  </ul>
  <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
