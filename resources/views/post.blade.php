<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
    @foreach ($posts as $post)
        
    
    <article class="py-8 max-w-screen-md">
        <h2 class="mb-1 text-3xl tracking-tight font-bold">{{ $post['title'] }}</h2>
        <div class="text-base text-gray-500">
            <a href="#">{{ $post['author'] }}</a> |4 Agustus 2024
        </div>
        <p class="my-4 font-light">{{ $post['body'] }}</p>
    </article>
    @endforeach
    {{-- <div class="relative overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Surat Masuk</th>
                    <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Petugas</th>
                    <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Hasil</th>
                    <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Bukti</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-4 py-2 sm:px-6 sm:py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Apple MacBook Pro 17"
                    </th>
                    <td class="px-4 py-2 sm:px-6 sm:py-4">Silver</td>
                    <td class="px-4 py-2 sm:px-6 sm:py-4">Laptop</td>
                    <td class="px-4 py-2 sm:px-6 sm:py-4">$2999</td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-4 py-2 sm:px-6 sm:py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Microsoft Surface Pro
                    </th>
                    <td class="px-4 py-2 sm:px-6 sm:py-4">White</td>
                    <td class="px-4 py-2 sm:px-6 sm:py-4">Laptop PC</td>
                    <td class="px-4 py-2 sm:px-6 sm:py-4">$1999</td>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-4 py-2 sm:px-6 sm:py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Magic Mouse 2
                    </th>
                    <td class="px-4 py-2 sm:px-6 sm:py-4">Black</td>
                    <td class="px-4 py-2 sm:px-6 sm:py-4">Accessories</td>
                    <td class="px-4 py-2 sm:px-6 sm:py-4">$99</td>
                </tr>
            </tbody>
        </table>
    </div> --}}
    
   
</x-layout>