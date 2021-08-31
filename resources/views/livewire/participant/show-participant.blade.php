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
                        Informasi Peserta
                    </h3>
                    <p class="mt-1 text-center text-sm text-gray-500">
                        Informasi Pendaftaran dan Kelas
                    </p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Nama
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $participant->name }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Alamat
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $participant->address }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Email / Phone
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $participant->email }} / {{ $participant->phone }}
                            </dd>
                        </div>
                        
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Tanggal Mendaftar
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $participant->created_at->isoFormat('D MMMM Y, HH:mm') }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Status Pendaftaran
                            </dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 sm:mt-0 sm:col-span-2 flex flex-wrap content-center items-center">
                                <div>
                                    : {{ $participant->status->status }}
                                </div>

                                {{-- selama statusnya blm selesai atau kadaluwarsa maka tampilkan --}}
                                @if (!$participant->hasAnyPermission([1, 2, 3]))
                                <div class="px-4 content-center justify-center">
                                    <form wire:submit.prevent="actionToParticipant">
                                        <label class="block">
                                            <select wire:model="status" class="text-xs h-0.5">
                                                <option hidden>Pilih Tindakan</option>
                                                @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}" class="text-xs h-0.5">{{ $status->status }}</option>
                                                @endforeach
                                            </select>
                                            <button class="py-1 px-2 bg-indigo-600 rounded-xl" type="submit">pilih</button>
                                        </label>
                                    </form>
                                </div>
                                @endif
                                
                                
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Kelas
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $participant->kelas->nama }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Waktu Pelaksanaan TOEFL
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                : {{ $participant->kelas->pelaksanaan->isoFormat('D MMMM Y, H:mm') }} ({{ $participant->kelas->pelaksanaan->diffForHumans() }}) 
                            </dd>
                        </div>
                    
                        {{-- kalau ada permission melihat hasil (sudah selesai mengerjakan) --}}
                        
                        @if ($participant->hasAnyPermission([1, 3]))
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Hasil Kerja TOEFL
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sections</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Dikerjakan</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Benar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">Listening Comprehension</td>
                                                            <td>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    30
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    15
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">Listening Comprehension</td>
                                                            <td>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    30
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    15
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">Listening Comprehension</td>
                                                            <td>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    30
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    15
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">FINAL SCORE</td>
                                                            <td class="text-left">
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    15
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col py-4">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sections</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Soal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">Listening Comprehension</td>
                                                            <td>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    30
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">Listening Comprehension</td>
                                                            <td>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    30
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">Listening Comprehension</td>
                                                            <td>
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    30
                                                                </span>
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
                        @endif
                    
            
                        <div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Attachments
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div>
                                    <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <!-- Heroicon name: solid/paper-clip -->
                                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2 flex-1 w-0 truncate">
                                                    bukti pembayaran
                                                </span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <button wire:click="downloadReceipt" class="font-medium text-indigo-600 hover:text-indigo-500">Lihat</button>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <button wire:click="downloadReceipt" class="font-medium text-indigo-600 hover:text-indigo-500">Download</button>
                                            </div>
                                        </li>
                
    
                                        {{-- download certificate kalau ada isinya --}}
                                        @if ($participant->certificate)
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <!-- Heroicon name: solid/paper-clip -->
                                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2 flex-1 w-0 truncate">
                                                    sertifikat toefl
                                                </span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                                Download
                                                </a>
                                            </div>
                                        </li>
                                        @endif
                                        
                                    </ul>
                                </div>

                                {{-- tampilakan form upload sertifikat jika status sudah selesai --}}
                                @if ($participant->status->id == 5)
                                <div>
                                    <div class="mt-5 md:mt-0">
                                        <form wire:submit.prevent="uploadCertificate">
                                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                                <div class="px-4 bg-white space-y-2 sm:p-6">
                                                    <label class="text-right block text-sm font-medium text-gray-700">
                                                        Upload Sertifikat
                                                    </label>
                                                    <div class="mt-1 flex justify-end items-center">
                                                        <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                              </svg>
                                                        </span>
                                                        <input wire:model="certificate" type="file" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    </div>
                                                    @error('certificate') <span class="text-red-600 font-semibold flex justify-end">{{ $message }}</span> @enderror
                                                    
                                                </div>
                                                <div class="px-4 pb-3 bg-gray-50 text-right sm:px-6">
                                                    <button type="submit" class="inline-flex justify-center py-1 px-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
