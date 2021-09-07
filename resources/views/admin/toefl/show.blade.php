<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('SHOW TOEFL : ') }} {{ $toefl->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            {{-- kalau ga dipakai di kelas, bisa dihapus --}}
            @if ( $toefl->kelas_count == 0 )
            <div class="my-2">
                <form action="/admin/toefls/{{ $toefl->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-lg px-3 py-1 bg-red-600 text-white hover:bg-red-300">Hapus</button>
                </form>
            </div>
            @endif
            

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 text-center py-1">
                            Data TOEFL
                        </h3>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Judul
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $toefl->title }}  
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Waktu dibuat:
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $toefl->created_at->isoFormat('D MMMM Y, HH:mm') }}  
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Data Soal
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <p>: {{ $toefl->questions->count() }} / 140 (kurang {{ 140-$toefl->questions->count() }} soal) </p>
                                <div class="flex flex-col">
                                    @if (session()->has('message'))
                                    <div class="text-red-500 font-semibold text-center text-base">
                                        {{ session('message') }}
                                    </div>
                                    @endif
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Sections</th>
                                                            <th scope="col" colspan="3" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider  border-r">Sub Sections</th>
                                                            <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Total</th>
                                                            <th scope="col" class="relative px-3 py-3">
                                                                <span class="sr-only">Aksi</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        <tr class="text-center ">
                                                            <td class="px-4 py-4 whitespace-nowrap border-r text-center">Section 1</td>
                                                            <td class="px-4 py-4 whitespace-nowrap border-r text-center">
                                                                <p class="text-sm">Part A</p>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    {{ $toefl->part_a_count }}
                                                                </span>/30
                                                            </td>
                                                            <td class="px-4 py-4 whitespace-nowrap border-r text-center">
                                                                <p class="text-sm">Part B</p>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    {{ $toefl->part_b_count }}
                                                                </span>/8
                                                            </td>
                                                            <td class="px-4 py-4 whitespace-nowrap border-r text-center">
                                                                <p class="text-sm">Part C</p>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    {{ $toefl->part_c_count }}
                                                                </span>/12
                                                            </td>
                                                            <td class="px-4 py-4 whitespace-nowrap border-r text-center">
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    {{ $toefl->section_1_count }}
                                                                </span>/50
                                                            </td>
                                                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium border-r">
                                                                <a href="/admin/toefls/{{ $toefl->id }}/sections/1/questions/create" class="text-indigo-500 hover:bg-indigo-900">Kelola</a>
                                                            </td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <td class="px-4 py-4 whitespace-nowrap border-r text-center">Section 2</td>
                                                            <td colspan="2" class="px-4 py-4 whitespace-nowrap border-r text-center">
                                                                <p class="text-sm">Structure</p>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    {{ $toefl->structure_count }}
                                                                </span>/15
                                                            </td>
                                                            <td class="px-4 py-4 whitespace-nowrap border-r text-center">
                                                                <p class="text-sm">Written Expression</p>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    {{ $toefl->written_expression_count }}
                                                                </span>/25
                                                            </td>
                                                            <td class="px-4 py-4 whitespace-nowrap border-r text-center">
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    {{ $toefl->section_2_count }}
                                                                </span>/40
                                                            </td>
                                                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium border-r">
                                                                <a href="/admin/toefls/{{ $toefl->id }}/sections/2/questions/create" class="text-indigo-500 hover:bg-indigo-900">Kelola</a>
                                                            </td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <td class="px-4 py-4 whitespace-nowrap border-r text-center">Section 3</td>
                                                            <td colspan="3" class="border-r">
                                                                
                                                            </td>
                                                            <td class="px-4 py-4 whitespace-nowrap border-r text-center">
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    {{ $toefl->section_3_count }}
                                                                </span>/50
                                                            </td>
                                                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium border-r">
                                                                <a href="/admin/toefls/{{ $toefl->id }}/sections/3/questions/create" class="text-indigo-500 hover:bg-indigo-900">Kelola</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </dd>
                        </div>
                        
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Data Penggunaan Kelas
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <p>: digunakan {{ $toefl->kelas_count }} kelas</p>
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Nama Kelas</th>
                                                            <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Pelaksanaan</th>
                                                            <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @foreach ($toefl->kelas as $kelas)
                                                        <tr class="text-center">
                                                            <td class="px-3 py-2 whitespace-nowrap border-r">
                                                                <a href="#">{{ $kelas->nama }}</a>
                                                            </td>
                                                            <td class="px-3 py-2 whitespace-nowrap border-r">
                                                                <p class="text-sm text-gray-900">{{ $kelas->pelaksanaan->isoFormat('dddd, D MMMM Y') }}</p>
                                                            </td>
                                                            <td>
                                                                <p class="text-sm text-gray-900">
                                                                    {{ $kelas->registerStatus->status }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </dd>
                        </div>

                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Data Penggunaan Peserta
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="flex flex-row">
                                    <div>
                                        <p>: telah dikerjakan oleh {{ $toefl->users_count }} peserta</p>
                                    </div>
                                    <div class="px-4">
                                        <a href="" class="text-indigo-500 hover:text-indigo-900 font-bold">lihat</a>
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>