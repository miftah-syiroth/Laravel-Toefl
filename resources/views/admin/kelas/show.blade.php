<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('DETIL KELAS : ') }} {{ $kelas->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div>
                    {{-- <livewire:kelas.show.status-form :kelas="$kelas" :statuses="$statuses"/> --}}
                </div>
                <ul>
                    <li>status</li>
                    <li>Peserta pendaftaran
                        <ul class="ml-4">
                            <li>total pendaftar</li>
                            <li>total verified</li>
                            <li>siswa pengajuan</li>
                        </ul>
                    </li>
                </ul>
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
