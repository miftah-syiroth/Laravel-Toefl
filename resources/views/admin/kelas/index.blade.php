<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('INDEX KELAS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="block mb-4">
                <a href="/admin/kelas/create" type="submit" class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-300 md:py-4 md:text-lg md:px-10">Buat Kelas Baru</a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:kelas.index />            
            </div>
        </div>
    </div>
</x-app-layout>
