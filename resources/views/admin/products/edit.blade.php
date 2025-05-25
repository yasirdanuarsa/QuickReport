@extends('admin.admin')

@section('edit')
<div class="container mt-5">
  <h3 class="mb-4">Edit Laporan</h3>

  <form action="{{ route('monev.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Jenis Laporan --}}
    <div class="mb-3">
      <label for="report_type">Jenis Laporan</label>
      <select name="report_type" class="form-select" required>
        <option value="surat_masuk" {{ $laporan->report_type == 'surat_masuk' ? 'selected' : '' }}>Surat Masuk</option>
        <option value="telepon" {{ $laporan->report_type == 'telepon' ? 'selected' : '' }}>Telepon</option>
      </select>
    </div>

    {{-- Nomor Telepon --}}
    <div class="mb-3">
      <label for="nomor_telepon">Nomor Telepon</label>
      <input type="text" name="nomor_telepon" class="form-control" value="{{ $laporan->nomor_telepon }}">
    </div>

    {{-- Upload Surat Masuk --}}
    <div class="mb-3">
      <label for="surat_masuk_file">Upload Surat Masuk (PDF/JPG/PNG)</label>
      <input type="file" name="surat_masuk_file" class="form-control">
      @if($laporan->surat_masuk_path)
        <small>File lama: <a href="{{ asset('storage/' . $laporan->surat_masuk_path) }}" target="_blank">Lihat File</a></small>
      @endif
    </div>

    {{-- Aktivitas --}}
    <div class="mb-3">
      <label for="activity">Jenis Aktivitas</label>
      <select name="activity" class="form-select" required>
        @foreach(['Rapat','Koordinasi','Monitoring','Evaluasi'] as $act)
          <option value="{{ $act }}" {{ $laporan->activity == $act ? 'selected' : '' }}>{{ $act }}</option>
        @endforeach
      </select>
    </div>

    {{-- Tanggal --}}
    <div class="mb-3">
      <label for="tanggal_laporan">Tanggal Laporan</label>
      <input type="date" name="tanggal_laporan" class="form-control" value="{{ $laporan->tanggal_laporan }}" required>
    </div>

    {{-- Perihal --}}
    <div class="mb-3">
      <label for="perihal">Perihal</label>
      <input type="text" name="perihal" class="form-control" value="{{ $laporan->perihal }}" required>
    </div>

    {{-- Instansi --}}
    <div class="mb-3">
      <label for="instansi">Instansi</label>
      <input type="text" name="instansi" class="form-control" value="{{ $laporan->instansi }}" required>
    </div>

    {{-- Petugas --}}
    <div class="mb-3">
      <label for="petugas_id">Nama Petugas</label>
      <select name="petugas_id" class="form-select" required>
        @foreach($petugas as $p)
          <option value="{{ $p->id }}" {{ $laporan->users_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
        @endforeach
      </select>
    </div>
    {{-- Hasil Kegiatan --}}
    <div class="mb-3">
        <label for="hasil">Hasil Kegiatan</label>
        <textarea name="hasil" class="form-control" rows="4">{{ $laporan->hasil }}</textarea>
    </div>
  
  {{-- Bukti (Foto) --}}
    <div class="mb-4">
        <label for="bukti">Upload Bukti Kegiatan (Foto)</label>
        <input type="file" name="bukti" class="form-control">
            @if($laporan->bukti)
            <small class="d-block mt-2">
             Bukti lama: <br>
             <img src="{{ asset('storage/' . $laporan->bukti) }}" alt="Bukti" width="200">
            </small>
            @endif
    </div>
  

    {{-- Status --}}
    <div class="mb-4">
      <label for="status">Status</label>
      <select name="status" class="form-select" required>
        <option value="pending" {{ $laporan->status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
      </select>
    </div>
    {{-- Deadline --}}
    <div class="mb-3">
      <label for="deadline">Deadline</label>
      <input type="date" name="deadline" class="form-control" value="{{ $laporan->deadline }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('monev.index') }}" class="btn btn-secondary">Kembali</a>
  </form>
</div>
@endsection
