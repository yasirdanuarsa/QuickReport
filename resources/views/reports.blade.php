<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
  
    {{-- Tabel Laporan --}}
    <div class="relative overflow-x-auto sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th class="px-4 py-2">No</th>
            <th class="px-4 py-2">Jenis Laporan</th>
            <th class="px-4 py-2">Tanggal</th>
            <th class="px-4 py-2">Perihal</th>
            <th class="px-4 py-2">Instansi</th>
            <th class="px-4 py-2">Aktivitas</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Petugas</th>
            <th class="px-4 py-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($data as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
              <td class="px-4 py-2">{{ $loop->iteration }}</td>
              <td class="px-4 py-2">{{ ucfirst($item->report_type) }}</td>
              <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d-m-Y') }}</td>
              <td class="px-4 py-2">{{ $item->perihal }}</td>
              <td class="px-4 py-2">{{ $item->instansi }}</td>
              <td class="px-4 py-2">{{ $item->activity }}</td>
              <td class="px-4 py-2">
                <span class="px-2 py-1 rounded text-white text-xs
                  {{ $item->status == 'selesai' ? 'bg-green-600' : 'bg-yellow-500' }}">
                  {{ ucfirst($item->status) }}
                </span>
              </td>
              <td class="px-4 py-2">{{ $item->petugas->name ?? '-' }}</td>
              <td class="px-4 py-2">
                <div x-data="{ open: false }">
                  <button @click="open = true" class="text-blue-600 hover:underline">Lihat Detail</button>
              
                  <!-- Modal -->
                  <div x-show="open" x-transition class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                    <div @click.away="open = false" class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6 relative">
                      <button @click="open = false" class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl">&times;</button>
              
                      <h2 class="text-lg font-semibold mb-4">Detail Laporan</h2>
                      <div class="space-y-2 text-sm text-gray-700">
                        <p><strong>Jenis Laporan:</strong> {{ ucfirst($item->report_type) }}</p>
                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d-m-Y') }}</p>
                        <p><strong>Nomor Telepon:</strong> {{ $item->nomor_telepon }}</p>
                        @if($item->surat_masuk_path)
                        <p><strong>File Surat:</strong></p>
                        <a href="{{ asset('storage/' . $item->surat_masuk_path) }}" target="_blank" class="text-blue-600 underline">Lihat Surat</a>
                        @endif 
                        <p><strong>Perihal:</strong> {{ $item->perihal }}</p>
                        <p><strong>Instansi:</strong> {{ $item->instansi }}</p>
                        <p><strong>Aktivitas:</strong> {{ $item->activity }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($item->status) }}</p>
                        <p><strong>Petugas:</strong> {{ $item->petugas->name ?? '-' }}</p>
                        <p><strong>Hasil:</strong> {{ $item->hasil ?? '-' }}</p>
              
                        <p><strong>Bukti:</strong></p>
                        @if($item->bukti)
                          @if(Str::endsWith($item->bukti, ['.jpg', '.jpeg', '.png', '.gif']))
                            <img src="{{ asset('storage/' . $item->bukti) }}" class="rounded shadow max-w-xs">
                          @else
                            <a href="{{ asset('storage/' . $item->bukti) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                          @endif
                        @else
                          <p class="italic text-gray-400">Tidak ada bukti</p>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              
              
              
            </tr>
          @empty
            <tr><td colspan="9" class="text-center py-4">Belum ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </x-layout>
  