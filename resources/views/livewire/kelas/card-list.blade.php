<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Kelas
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Pelaksanaan</span>
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Pendaftaran</span>
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Harga</span>
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Peserta</span>
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Daftar</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($kelas as $key => $kelas)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $key + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $kelas->nama }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">{{ $kelas->pelaksanaan }}</div>
                                <div class="text-md font-medium text-indigo-600">3 hari lagi</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">{{ $kelas->pendaftaran }}</div>
                                <div class="text-md font-medium text-indigo-600">3 hari lagi</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $kelas->price }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">10 / {{ $kelas->quota }}</div>
                                <div class="text-md font-medium text-indigo-600">2 Orang lagi</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                {{-- <a href="/participant/kelas/{{ $kelas->id }}/register" class="text-indigo-600 hover:text-indigo-900">
                                    Daftar
                                </a> --}}
                                <a href="/participant/{{ $kelas->id }}/register" class="text-indigo-600 hover:text-indigo-900">
                                    Daftar
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    <!-- More people... -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 