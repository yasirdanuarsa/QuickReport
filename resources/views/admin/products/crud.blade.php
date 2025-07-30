@extends('admin.admin')

@section('crud')
<div class="container mt-5">
  <h2 class="mb-4 text-center">Input Laporan</h2>

  {{-- Alert feedback --}}
  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn btn-danger" data-bs-dismiss="alert" aria-label="Close">
      <i class="fas fa-times"></i>
    </button>
  </div>
  @endif

  {{-- Form --}}
  <form action="{{ route('monev.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Hidden input untuk report_type --}}
    <input type="hidden" id="report_type" name="report_type" value="surat_masuk">

    {{-- Tabs jenis laporan --}}
    <ul class="nav nav-pills mb-3" id="laporanTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-surat-masuk" data-bs-toggle="pill" type="button"
          data-bs-target="#surat_masuk" role="tab">Surat Masuk</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-telepon" data-bs-toggle="pill" type="button"
          data-bs-target="#telepon" role="tab">Telepon</button>
      </li>
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content" id="laporanTabContent">
      {{-- Surat Masuk --}}
      <div class="tab-pane fade show active" id="surat" role="tabpanel">
        <div class="form-group mb-3">
          <label for="surat_masuk_file">Upload Surat (PDF/JPG/PNG)</label>
          <input type="file" id="surat_masuk_file" name="surat_masuk_file" class="form-control">
        </div>
      </div>

      {{-- Telepon --}}
      <div class="tab-pane fade" id="telepon" role="tabpanel">
        <div class="form-group mb-3">
          <label for="nomor_telepon">Nomor Telepon</label>
          <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control">
        </div>
      </div>
    </div>

    {{-- Jenis Aktivitas --}}
    <div class="form-group mb-3">
      <label for="activity">Jenis Aktivitas</label>
      <select name="activity" id="activity" class="form-select" required>
        <option value="">Pilih Aktivitas</option>
        <option value="Rapat">Rapat</option>
        <option value="Kunjungan">Koordinasi</option>
        <option value="Monitoring">Monitoring</option>
        <option value="Evaluasi">Evaluasi</option>
      </select>
    </div>

    {{-- Tanggal Laporan --}}
    <div class="form-group mb-3">
      <label for="tanggal_laporan">Tanggal Laporan</label>
      <input type="date" name="tanggal_laporan" class="form-control" required>
    </div>

    {{-- Perihal --}}
    <div class="form-group mb-3">
      <label for="perihal">Perihal</label>
      <input type="text" name="perihal" class="form-control" required>
    </div>

    {{-- Instansi --}}
    <div class="form-group mb-3">
      <label for="instansi">Instansi</label>
      <input type="text" name="instansi" class="form-control" required>
    </div>

    {{-- Nama Petugas --}}
    <div class="form-group mb-3">
      <label for="petugas_id">Nama Petugas</label>
      <select name="petugas_id" class="form-select" required>
        <option value="">-- Pilih Petugas --</option>
        @foreach($petugas as $p)
          <option value="{{ $p->id }}">{{ $p->name }}</option>
        @endforeach
      </select>
    </div>
    {{-- Deadline --}}
    <div class="form-group mb-3">
        <label for="deadline" class="form-label">Deadline</label>
        <input type="date" name="deadline" class="form-control" required>
    </div>


    <button type="submit" class="btn btn-primary w-100">Simpan Laporan</button>
  </form>
</div>

{{-- Script untuk toggle report_type --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const reportInput = document.getElementById('report_type');

    document.getElementById('tab-surat').addEventListener('click', function () {
      reportInput.value = 'surat_masuk';
      document.getElementById('surat_masuk_file').required = true;
      document.getElementById('nomor_telepon').required = false;
    });

    document.getElementById('tab-telepon').addEventListener('click', function () {
      reportInput.value = 'telepon';
      document.getElementById('surat_masuk_file').required = false;
      document.getElementById('nomor_telepon').required = true;
    });
  });
</script>
@endsection
