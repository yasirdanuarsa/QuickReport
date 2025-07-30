@section('tabel')
<div class="container-fluid my-3">
  <div class="row justify-content-center">    
    <div class="row">
      <div class="col-md-3 mb-4 text-center">
        <h6>Laporan Per Bulan</h6>
        <canvas id="chartBulanan" style="max-height: 200px;"></canvas>
      </div>
      <div class="col-md-3 mb-4 text-center">
        <h6>Laporan Harian</h6>
        <canvas id="chartHarian" style="max-height: 200px;"></canvas>
      </div>
      <div class="col-md-3 mb-4 text-center">
        <h6>Status Laporan</h6>
        <canvas id="chartStatus" style="max-height: 200px;"></canvas>
      </div>
      <div class="col-md-3 mb-4 text-center">
        <h6>Laporan per Petugas</h6>
        <canvas id="chartLaporanPetugas" style="max-height: 230px;"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection