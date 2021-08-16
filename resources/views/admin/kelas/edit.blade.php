<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('EDIT KELAS : ') }} {{ $kelas->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="/admin/kelas/{{ $kelas->id }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="border-2 py-2">
                        <label for="nama">Nama Kelas : </label>
                        <input value="{{ $kelas->nama ?? old('nama') }}" type="text" name="nama" id="nama"  class="@error('nama') is-invalid @enderror">
                        @error('nama')
                        <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="border-2 py-2">
                        <label for="pelaksanaan">Tanggal Pelaksanaan : </label>
                        <input value="{{ $kelas->pelaksanaan ?? old('pelaksanaan') }}" type="datetime-local" name="pelaksanaan" id="pelaksanaan" class="@error('pelaksanaan') is-invalid @enderror">
                        @error('pelaksanaan')
                        <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="border-2 py-2">
                        <label for="pendaftaran">Batas Waktu Pendaftaran : </label>
                        <input value="{{ $kelas->pendaftaran ?? old('pendaftaran') }}" type="datetime-local" name="pendaftaran" id="pendaftaran" class="@error('pendaftaran') is-invalid @enderror">
                        @error('pendaftaran')
                        <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                        @enderror
                        <small><p>optional kalau belum ada</p></small>
                    </div>
                    <div class="border-2 py-2">
                        <label for="quota">Kuota Peserta</label>
                        <input value="{{ $kelas->quota ?? old('quota') }}" type="number" name="quota" id="quota" class="@error('quota') is-invalid @enderror">
                        @error('quota')
                        <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="border-2 py-2">
                        <label for="toefls">Pilih Toefl yang akan digunakan</label>
                        <select name="toefls[]" id="toefls" multiple class="@error('toefls') is-invalid @enderror">
                            @foreach ($kelas->toefls as $toefl)
                            <option disabled>{{ $toefl->title }}</option>
                            @endforeach

                            @foreach ($toefls as $toefl)
                            <option value="{{ $toefl->id }}">{{ $toefl->title }}</option>
                            @endforeach
                        </select>
                        @error('toefls')
                        <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <button class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-300 md:py-4 md:text-lg md:px-10" type="submit">Simpan Perubahan Kelas</button>
                    </div>
                </form>    
            </div>
            <div class="block mt-4">
                <form action="/admin/kelas/{{ $kelas->id }}" method="POST">
                    @method('DELETE')
                    @csrf 
                    <button type="submit" class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-300 md:py-4 md:text-lg md:px-10">Hapus Kelas</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
