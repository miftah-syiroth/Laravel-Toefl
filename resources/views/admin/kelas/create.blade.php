<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('BUAT KELAS BARU') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4">
                <div class="mx-auto w-3/4 py-12 px-4 flex flex-row justify-center">
                    <div class="mt-5 px-4 w-3/4">
                        <form action="/admin/kelas" method="post" class="px-4">
                            @csrf
                            <div class="grid grid-cols-1 gap-6 px-4">
                                <label class="block">
                                    <span class="text-gray-700">Nama Kelas</span>
                                    <input value="{{ old('nama') }}" type="text" name="nama" id="nama" placeholder="Nama Kelas .." class="form-input mt-1 block w-full">
                                    @error('nama')
                                    <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Kuota Peserta</span>
                                    <input value="{{ old('quota') }}" type="number" name="quota" id="quota" class="@error('quota') is-invalid @enderror form-input mt-1 block w-full">
                                    @error('quota')
                                    <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Harga Kelas</span>
                                    <input value="{{ old('price') }}" type="number" name="price" id="price" class="@error('price') is-invalid @enderror form-input mt-1 block w-full">
                                    @error('price')
                                    <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Tanggal Pelaksanaan</span>
                                    <input value="{{ old('pelaksanaan') }}" type="datetime-local" name="pelaksanaan" id="pelaksanaan" placeholder="Waktu Pelaksanaan" class="@error('pelaksanaan') is-invalid @enderror form-input mt-1 block w-full">
                                    @error('pelaksanaan')
                                    <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Batas Waktu Selesai Pelaksanaan</span>
                                    <input value="{{ old('akhir_pelaksanaan') }}" type="datetime-local" name="akhir_pelaksanaan" id="akhir_pelaksanaan" class="@error('akhir_pelaksanaan') is-invalid @enderror form-input mt-1 block w-full">
                                    @error('akhir_pelaksanaan')
                                    <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Batas Pendaftaran</span>
                                    <input value="{{ old('pendaftaran') }}" type="datetime-local" name="pendaftaran" id="pendaftaran" class="@error('pendaftaran') is-invalid @enderror form-input mt-1 block w-full">
                                    @error('pendaftaran')
                                    <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Pilih Toefl yang Digunakan</span>
                                    <select name="toefls[]" id="toefls" multiple class="@error('toefls') is-invalid @enderror form-multiselect block w-full mt-1">
                                        @foreach ($toefls as $toefl)
                                            <option value="{{ $toefl->id }}">{{ $toefl->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('toefls')
                                    <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="block">
                                    <button class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-300" type="submit">Buat Kelas Baru</button>
                                </label>
                            </div>
                        </form> 
                    </div>
                </div>  
            </div>
        </div>
    </div>
</x-app-layout>
