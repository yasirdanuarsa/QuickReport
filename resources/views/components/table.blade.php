<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">id</th>
                <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Surat Masuk</th>
                <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Kegiatan</th>
                <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Petugas</th>
                <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Hasil</th>
                <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Bukti</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td><a href="{{ asset('storage/' . $item->surat_masuk) }}">Lihat File</a></td>
                <td>{{ $item->kegiatan }}</td>
                <td>{{ $item->nama_petugas }}</td>
                <td>{{ $item->hasil }}</td>
                <td><img src="{{ asset('storage/' . $item->bukti) }}" width="100"></td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center">Belum ada data</td></tr>
            @endforelse
          </tbody>
    </table>
</div>