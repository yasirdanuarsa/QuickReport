<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
  
<div class="container mt-5">
  <h3 class="mb-4">Detail Laporan</h3>
  <table class="table table-bordered">
    <tr><th>Jenis Laporan</th><td>{{ ucfirst($laporan->report_type) }}</td></tr>

    @if ($laporan->report_type === 'telepon')
      <tr><th>Nomor Telepon</th><td>{{ $laporan->nomor_telepon ?? '-' }}</td></tr>
    @else
      <tr>
        <th>File Surat Masuk</th>
        <td>
          @if($laporan->surat_masuk_path)
            <a href="{{ asset('storage/' . $laporan->surat_masuk_path) }}" target="_blank">Lihat File</a>
          @else
            -
          @endif
        </td>
      </tr>
    @endif

    <tr><th>Aktivitas</th><td>{{ $laporan->activity }}</td></tr>
    <tr><th>Tanggal Laporan</th><td>{{ $laporan->tanggal_laporan }}</td></tr>
    <tr><th>Perihal</th><td>{{ $laporan->perihal }}</td></tr>
    <tr><th>Instansi</th><td>{{ $laporan->instansi }}</td></tr>
    <tr><th>Status</th><td>
      <span class="badge bg-{{ $laporan->status == 'selesai' ? 'success' : 'warning' }}">
        {{ ucfirst($laporan->status) }}
      </span>
    </td></tr>
    <tr><th>Petugas</th><td>{{ $laporan->petugas->name }}</td></tr>

    <tr><th>Hasil Kegiatan</th>
      <td>
        {{ $laporan->hasil ?? '-' }}
      </td>
    </tr>

    <tr>
      <th>Bukti Foto</th>
      <td>
        @if($laporan->bukti)
          <img src="{{ asset('storage/' . $laporan->bukti) }}" alt="Bukti Foto" class="img-fluid" style="max-width: 300px;">
        @else
          <span class="text-muted">Tidak ada bukti</span>
        @endif
      </td>
    </tr>
  </table>

  <a href="{{ route('monev.index') }}" class="btn btn-secondary">← Kembali</a>
</div>
</x-layout>
