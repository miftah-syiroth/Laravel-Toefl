<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('SHOW TOEFL : ') }} {{ $toefl->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="block mb-4">
                <a href="/admin/toefls/create" type="submit" class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-300 md:py-4 md:text-lg md:px-10">Kelola Soal</a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div>
                    <ul>
                        <li>tanggal dibuat</li>
                        <li>informasi kelas yang menggunakan toefl ini</li>
                        <li>Jumlah soal X/total apakah sudah terpenuhi</li>
                        <li>Jumlah soal tiap section apakah sudah terpenuhi</li>
                        <li>informasi peserta yang menggunakan toefl ini</li>
                    </ul>
                </div>
                <div>
                    <h1>SOAL : {{ $toefl->questions()->count() }}/{{ $total_question }}</h1>
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Section
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Question
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <span>Action</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($sections as $key => $section)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $section->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $toefl->questions()->where('section_id', $section->id)->count() }} / {{ $section->total_question }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="/admin/toefls/{{ $toefl->id }}/sections/{{ $section->id }}/questions/create" class="text-indigo-600 hover:text-indigo-900">Kelola Soal</a>
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
                </div>           
            </div>
        </div>
    </div>
</x-app-layout>
