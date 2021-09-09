<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('TOEFLS INDEX') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row justify-between">
                <div class="mb-2">
                    <a href="/admin/toefls/create" class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-300">Create New Toefl</a>
                </div>
                <div class="mb-2">
                    <form wire:submit.prevent="sorting">
                        <div class="flex flex-row">
                            <div>
                                <select wire:model="sortBy" class="text-sm form-select rounded-lg">
                                    <option hidden>Sort By</option>
                                    <option value="title">Judul</option>
                                    <option value="created_at">Waktu Dibuat</option>
                                    <option value="kelas_count">Jumlah Kelas</option>
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
                                <button class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-300">filter</button>
                            </div>
                        </div>
                    </form>
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
                                            <th scope="col" class="px-2 py-3 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider border-r">
                                                No.
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Judul
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Waktu Dibuat
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Jumlah Soal
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Penggunaan Kelas
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Penggunaan Peserta
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Detil</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody wire:poll="updateToefls" class="bg-white divide-y divide-gray-200">
            
                                        @foreach ($toefls as $key => $toefl)
                                        <tr>
                                            <td class="px-2 py-2 whitespace-nowrap border-r text-center">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $key + 1 }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $toefl->title }}</div>
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-center">
                                                <div class="text-sm text-gray-900">
                                                    {{ $toefl->created_at->isoFormat('D MMMM YYYY, HH:mm') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-center">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $toefl->questions_count }}
                                                </span>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    / 140
                                                </span>
                                                <p class="px-2 text-xs text-red-600">
                                                    {{ $toefl->questions_count < 140 ? 'uncompleted' : 'completed' }}
                                                </p>
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-center">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $toefl->kelas_count }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-center">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $toefl->users_count }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="/admin/toefls/{{ $toefl->id }}/edit" class="text-green-800 hover:text-green-900 px-2">Edit</a>
                                                <a href="/admin/toefls/{{ $toefl->id }}" class="text-indigo-600 hover:text-indigo-900 px-2">Detil</a>
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