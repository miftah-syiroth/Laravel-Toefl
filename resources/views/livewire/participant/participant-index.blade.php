<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peserta')  }} {{ $kelas->nama ?? '' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row">
                <div class="bg-gray-200 px-2 py-2 mb-4 rounded-lg mr-2">
                    <form wire:submit.prevent="filtering">
                        <div class="flex flex-row">
                            <div>
                                <select wire:model="participant_status" class="text-sm rounded-lg">
                                    <option hidden>Pilih status</option>
                                    <option value="1">Pengajuan Pendaftaan</option>
                                    <option value="2">Pendaftaran Diterima</option>
                                    <option value="3">Pendaftaran Ditolak</option>
                                    <option value="5">Telah Selesai</option>
                                    <option value="6">Kadaluwarsa</option>
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
                                    <option value="name">Nama</option>
                                    <option value="created_at">Waktu Mendaftar</option>
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
                <div class="bg-gray-200 px-2 py-2 mb-4 rounded-lg mr-2 flex items-center">
                    <a href="/admin/participants/export/{{ $kelas ? $kelas->id : '' }}" class="px-2 py-1 bg-indigo-500 text-sm text-white rounded-lg">CETAK XLS</a>
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
                                            <th scope="col" class="px-2 py-3 border-r text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                No
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Kelas
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Waktu Mendaftar
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Skor Toefl
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Sertifikat
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Detil</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($participants as $key => $participant)
                                        <tr>
                                            <td class="px-2 py-4 whitespace-nowrap border-r text-center">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $key + 1 }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $participant->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-center text-gray-900">
                                                    <a href="/admin/participants/kelas/{{ $participant->kelas_id }}" class="text-indigo-600 hover:text-indigo-900">{{ $participant->kelas->nama }}</a>
                                                </div>
                                                
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-center font-semibold">
                                                    {{ $participant->created_at->isoFormat('D MMMM YYYY, HH:mm') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-center text-gray-900">
                                                    {{ $participant->status->status }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-center text-gray-900">
                                                    {{ $participant->score ? $participant->score->final_score : 0 }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-center text-gray-900">
                                                    {{ $participant->certificate ? 'uploaded' : '' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="/admin/participants/{{ $participant->id }}" class="text-indigo-600 hover:text-indigo-900">Detil</a>
                                            </td>
                                        </tr>
                                        @endforeach
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


