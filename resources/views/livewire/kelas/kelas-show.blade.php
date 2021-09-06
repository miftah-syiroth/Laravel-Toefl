<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peserta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 justify-center text-center">
                        Informasi Kelas
                    </h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Nama Kelas
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $kelas->nama }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Waktu Pelaksanaan
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $kelas->pelaksanaan->isoFormat('dddd, DD MMMM Y hh:mm A') }} / {{ $kelas->pelaksanaan->diffForHumans() }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Waktu Pendaftaran
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $kelas->pendaftaran->isoFormat('dddd, DD MMMM Y hh:mm A') }} / {{ $kelas->pendaftaran->diffForHumans() }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Status Publikasi
                            </dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 sm:mt-0 sm:col-span-2 flex flex-row">
                                <div class="w-full">
                                    : {{ $kelas->ispublished ? 'terpublikasi' : 'tidak dipublikasi' }}
                                </div>
                                <div class="ml-4 w-full content-center justify-center">
                                    <button wire:click="publication" class="text-indigo-600"> {{ $kelas->ispublished ? 'hilangkan publikasi' : 'publikasikan' }}</button>
                                </div>
                            </dd>
                        </div>

                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Status Pendaftaran
                            </dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 sm:mt-0 sm:col-span-2 flex flex-row">
                                <div class="w-full">
                                    : {{ $kelas->registerStatus ? $kelas->registerStatus->status : '' }}
                                </div>
                                <div class="w-full flex flex-row">
                                    @foreach ($register_statuses as $status)
                                    <button wire:click="registration({{ $status->id }})" class="text-indigo-600 px-4">{{ $status->status }}</button>
                                    @endforeach
                                </div>
                            </dd>
                        </div>

                        <div wire:poll.5000="updateKelas" class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Data Peserta
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="flex flex-row">
                                    <div class="w-full">
                                        : Total {{ $kelas->users_count }} Peserta Mendaftar / kuota {{ $kelas->quota }}
                                    </div>
                                    <div class="ml-4 w-full content-center justify-center">
                                        <a href="/admin/participants/kelas/{{ $kelas->id }}" class="text-indigo-600 hover:text-indigo-900">lihat</a>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="flex flex-col">
                                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                            <tr>
                                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ditolak</th>
                                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Diterima</th>
                                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Mengerjakan</th>
                                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kadaluwarsa</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            <tr>
                                                                <td class="text-center">
                                                                    <span class="px-2 my-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                        {{ $kelas->peserta_ditolak_count ?  $kelas->peserta_ditolak_count : 0}}
                                                                    </span>
                                                                    <div class="py-2">
                                                                        <a href="" class="text-indigo-600 hover:text-indigo-900">lihat</a>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="px-2 my-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                        {{ $kelas->peserta_mengerjakan_count + $kelas->peserta_kadaluwarsa_count }}
                                                                    </span>
                                                                    <div class="py-2">
                                                                        <a href="" class="text-indigo-600 hover:text-indigo-900">lihat</a>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="px-2 my-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                        {{ $kelas->peserta_mengerjakan_count ?  $kelas->peserta_mengerjakan_count : 0}}
                                                                    </span>
                                                                    <div class="py-2">
                                                                        <a href="" class="text-indigo-600 hover:text-indigo-900">lihat</a>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="px-2 my-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                        {{ $kelas->peserta_kadaluwarsa_count ?  $kelas->peserta_kadaluwarsa_count : 0}}
                                                                    </span>
                                                                    <div class="py-2">
                                                                        <a href="" class="text-indigo-600 hover:text-indigo-900">lihat</a>
                                                                    </div>
                                                                    
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="border-t border-gray-200">
                    <div class="flex items-center justify-end px-6 pb-4">
                        <div class="mt-5 flex ">
                            <span class="hidden sm:block mr-3">
                                <a href="/admin/kelas/{{ $kelas->id }}/edit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Edit
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
