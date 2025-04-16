<x-layout>
    <x-slot:title>Dashboard</x-slot>
  
    <div class="p-6 bg-white rounded-lg shadow-md">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang di <span class="text-blue-600">QuickReport Infrastruktur Jaringan</span></h1>
      <p class="text-gray-600 mb-6">
        Sistem Pelaporan Cepat milik <strong>Bidang Infrastruktur dan Statistik - Dinas Komunikasi dan Informatika Kota Pekalongan</strong>. 
        QuickReport mempermudah proses pemantauan, pengelolaan, dan evaluasi kegiatan <strong>Infrastruktur Jaringan</strong> dari berbagai instansi maupun laporan masyarakat.
      </p>
  
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-blue-100 border-l-4 border-blue-600 rounded-lg p-5">
          <h2 class="text-xl font-semibold text-blue-700 mb-2">Apa Itu QuickReport?</h2>
          <p class="text-sm text-gray-700">
            QuickReport adalah sistem informasi yang dirancang untuk menangani pelaporan kegiatan secara digital, 
            baik melalui surat maupun telepon. Tujuannya adalah menciptakan proses kerja yang efisien, cepat, dan terdokumentasi dengan baik.
          </p>
        </div>
  
        <div class="bg-green-100 border-l-4 border-green-600 rounded-lg p-5">
          <h2 class="text-xl font-semibold text-green-700 mb-2">Fitur Utama</h2>
          <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
            <li>Input laporan kegiatan berbasis digital</li>
            <li>Pelacakan status laporan (Pending/Selesai)</li>
            <li>Upload bukti kegiatan dan file surat</li>
            <li>Export laporan ke Excel</li>
            <li>Manajemen data petugas</li>
          </ul>
        </div>
      </div>
  
      <div class="mt-8 bg-yellow-100 border-l-4 border-yellow-600 rounded-lg p-5">
        <h2 class="text-xl font-semibold text-yellow-700 mb-2">Tentang Dinas Komunikasi dan Informatika Kota Pekalongan</h2>
        <p class="text-sm text-gray-700">
          Dinas Komunikasi dan Informatika Kota Pekalongan memiliki tugas menyelenggarakan urusan pemerintahan 
          di bidang komunikasi, informatika, statistik, dan persandian. QuickReport hadir sebagai bentuk inovasi dalam mendukung tugas tersebut secara digital dan efisien.
        </p>
      </div>
  
      <div class="mt-10 text-center text-sm text-gray-400">
        &copy; {{ date('Y') }} QuickReport — Dinas Komunikasi dan Informatika Kota Pekalongan
      </div>
    </div>
  </x-layout>
  