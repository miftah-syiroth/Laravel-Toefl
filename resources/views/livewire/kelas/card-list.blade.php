<div class="container mx-auto px-4">
    <div class="flex flex-row justify-center mb-4">
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
    
    
    <div wire:poll="updateKelas" class="grid grid-cols-3 gap-4">
        {{-- komponen card kelas --}}
        @foreach ($kelas as $key => $kelas)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">
                    {{ $kelas->nama }}
                </h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Kuota Peserta
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <p>{{ $kelas->users_count }} / {{ $kelas->quota }}</p>

                            @if ($kelas->quota <= $kelas->users_count)
                                <p class="text-red-600"> kuota habis! </p>
                            @else
                                <p>
                                    tersisa kuota  {{ $kelas->quota - $kelas->users_count }} peserta
                                </p>
                            @endif
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Harga
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            Rp. {{ $kelas->price }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Tanggal Pelaksanaan
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <p>{{ $kelas->pelaksanaan->isoFormat('dddd, D MMMM Y') }}</p>
                            <p>{{ $kelas->pelaksanaan->diffForHumans() }}</p>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Batas Pendaftaran
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <p>{{ $kelas->pendaftaran->isoFormat('dddd, D MMMM Y') }}</p>
                            <p>{{ $kelas->pendaftaran->diffForHumans() }}</p>
                        </dd>
                    </div>
                </dl>
                <dl class="border-t">
                    <div class="bg-gray-50 px-4 py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            {{-- kalau kuota penuh atau batas pendaftaran selesai --}}
                            @if ($kelas->register_status_id == 2 || $kelas->register_status_id == 3)
                                {{ $kelas->registerStatus->status }}
                            @else
                            <a href="/participant/{{ $kelas->id }}/register" class="bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg py-1 px-2">
                                Daftar
                            </a>
                            @endif
                        </dt>
                    </div>
                </dl>
            </div>
        </div>
        @endforeach
    </div>
</div>