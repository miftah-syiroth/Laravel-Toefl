<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('TOEFLS INDEX') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="block mb-4">
                <a href="/admin/toefls/create" class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-300">Create New Toefl</a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('toefl.toefl-list')
            </div>
        </div>
    </div>
</x-app-layout>