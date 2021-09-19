<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('KELOLA KELAS') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row justify-between">
                <div class="mb-4">
                    <a href="/admin/kelas/create" class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-300">Buat Kelas Baru</a>
                </div>
                <div class="flex flex-row">
                    <div class="bg-gray-200 px-2 py-2 mb-4 rounded-lg mr-2">
                        <form wire:submit.prevent="filtering">
                            <div class="flex flex-row">
                                <div>
                                    <select wire:model="register_status" class="text-sm rounded-lg">
                                        <option hidden>Pilih status</option>
                                        <option value="1">Pendaftaran Dibuka</option>
                                        <option value="2">Pendaftaran Ditutup</option>
                                        <option value="3">Telah Selesai</option>
                                    </select>
                                </div>
                                <div>
                                    <select wire:model="publication" class="text-sm rounded-lg">
                                        <option hidden>Pilih Publisitas</option>
                                        <option value="1">Published</option>
                                        <option value="0">Unpublished</option>
                                    </select>
                                </div>
                                <div class="px-4">
                                    <button class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-300">filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="bg-gray-200 px-2 py-2 mb-4 rounded-lg mr-2">
                        <form wire:submit.prevent="sorting">
                            <div class="flex flex-row">
                                <div>
                                    <select wire:model="sortBy" class="text-sm form-select rounded-lg">
                                        <option hidden>Sort By</option>
                                        <option value="nama">Judul</option>
                                        <option value="pelaksanaan">Waktu Pelaksanaan</option>
                                        <option value="pendaftaran">Waktu Pendaftaran</option>
                                        <option value="users_count">Jumlah Peserta</option>
                                    </select>
                                </div>
                                <div>
                                    <select wire:model="order" class="text-sm form-select rounded-lg">
                                        <option hidden>Order</option>
                                        <option value="ASC">Naik</option>
                                        <option value="DESC">Turun</option>
                                    </select>
                                </div>
                                <div class="px-4">
                                    <button class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-300">urutkan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider border-r">
                                                No.
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama Kelas
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Pelaksanaan
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Batas Pelaksanaan
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Batas Pendaftaran
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Publisitas
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status Pendaftaran
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Peserta Mendaftar
                                            </th>
                                            <th scope="col" class="relative px-4 py-3">
                                                <span class="sr-only">Kelola</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody wire:poll="updateKelas" class="bg-white divide-y divide-gray-200">
                                        @foreach ($kelas as $key => $kelas)
                                        <tr>
                                            <td class="px-2 py-4 whitespace-nowrap border-r">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $key + 1 }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border-r">
                                                <div class="text-sm text-gray-900">{{ $kelas->nama }}</div>
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                                <div class="text-sm text-gray-900">
                                                    <p>
                                                        {{ $kelas->pelaksanaan->isoFormat('D MMM Y, hh:mm') }}
                                                    </p>
                                                    <p class="font-semibold text-sm underline">
                                                        {{ $kelas->pelaksanaan->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="text-sm text-gray-900">
                                                    <p>
                                                        {{ $kelas->akhir_pelaksanaan->isoFormat('D MMM Y, hh:mm') }}
                                                    </p>
                                                    <p class="font-semibold text-sm underline">
                                                        {{ $kelas->akhir_pelaksanaan->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center border-r">
                                                <div class="text-sm text-gray-900">
                                                    <p>
                                                        {{ $kelas->pendaftaran->isoFormat('D MMM Y, hh:mm') }}
                                                    </p>
                                                    <p class="font-semibold text-sm underline">
                                                        {{ $kelas->pendaftaran->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="text-sm text-gray-900 font-semibold">
                                                    {{ $kelas->ispublished ? 'published' : 'unpublished' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                @if ($kelas->ispublished)
                                                    {{ $kelas->registerStatus ? $kelas->registerStatus->status : '' }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <p>{{ $kelas->users->count() }} / {{ $kelas->quota }} peserta</p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <a href="/admin/kelas/{{ $kelas->id }}" class="px-2 py-1 rounded-lg text-indigo-600 hover:text-indigo-900 hover:bg-gray-400">Kelola</a>
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