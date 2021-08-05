<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('CREATE TOEFLS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div>
                    <form action="/admin/toefls" method="post" enctype="multipart/form-data">
                        @csrf
                        <label class="block">
                            <span class="text-gray-700">Judul Toefl:</span>
                            <input type="text" name="title" id="title" class="form-input mt-1 block w-full @error('title') is-invalid @enderror" placeholder="Judul Toefl">
                            @error('title')
                                <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                            @enderror
                          </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Track Audio Section 1 :</span>
                            <input type="file" name="section_1_track" id="section_1_track" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                            @error('section_1_track')
                                <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                            @enderror
                        </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Petunjuk Utama Section 2 :</span>
                            <textarea name="section_2_direction" id="section_2_direction" class="form-textarea mt-1 block w-full" rows="3" placeholder="Direction . . ."></textarea>
                            @error('section_2_direction')
                                <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                            @enderror
                        </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Petunjuk Utama Section 3 :</span>
                            <textarea name="section_3_direction" id="section_3_direction" class="form-textarea mt-1 block w-full" rows="3" placeholder="Direction . . ."></textarea>
                            @error('section_3_direction')
                                <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                            @enderror
                        </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Petunjuk SubSection Structure :</span>
                            <textarea name="structure_direction" id="structure_direction" class="form-textarea mt-1 block w-full" rows="3" placeholder="Direction . . ."></textarea>
                            @error('structure_direction')
                                <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                            @enderror
                        </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Petunjuk SubSection Written Expression :</span>
                            <textarea name="written_expression_direction" id="written_expression_direction" class="form-textarea mt-1 block w-full" rows="3" placeholder="Direction . . ."></textarea>
                            @error('written_expression_direction')
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
