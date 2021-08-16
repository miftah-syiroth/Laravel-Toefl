<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('BUAT KELAS BARU') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div>
                    di sini dikasi komponen realtime ttg kelas tsb biar
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium numquam veritatis est placeat? Incidunt, amet at eveniet saepe praesentium quam provident delectus molestiae voluptas quasi explicabo deserunt. Ipsum, ab consequatur.
                </div>
                <div>
                    <form action="/participant/kelas/{{ $kelas->id }}/register" method="post" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <label class="block mt-4">
                            <span class="text-gray-700">Bukti pembayaran pendaftaran : </span>
                            <input type="file" name="receipt_of_payment" id="receipt_of_payment" class="form-input mt-1 block w-full" placeholder="masukkan bukti pembayaran online">
                            @error('receipt_of_payment')
                                <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                            @enderror
                        </label>
                        <div class="block mt-4 mb-4">
                            <button type="submit" class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-300 md:py-4 md:text-lg md:px-10">simpan</button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
