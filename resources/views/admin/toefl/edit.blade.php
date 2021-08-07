<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('EDIT TOEFL : ') }} {{ $toefl->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div>
                    <form action="/admin/toefls/{{ $toefl->id }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <label class="block">
                            <span class="text-gray-700">Judul Toefl:</span>
                            <input type="text" name="title" id="title" value="{{ $toefl->title ?? old('title') }}" class="form-input mt-1 block w-full @error('title') is-invalid @enderror" placeholder="Judul Toefl">
                            @error('title')
                                <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                            @enderror
                          </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Track Audio Section 1 :</span>
                            <figure class="text-gray-700 flex">
                                <figcaption class="mr-3">Track saat ini :</figcaption>
                                <audio controls src="{{ asset('/storage/'. $toefl->section_1_track) }}">
                                    Your browser does not support the audio element.
                                    <code>audio</code> element.
                                </audio>
                            </figure>
                            <input type="file" name="section_1_track" id="section_1_track" value="{{ $toefl->section_1_track ?? old('section_1_track') }}" class="form-input mt-1" placeholder="Jane Doe">
                            @error('section_1_track')
                                <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                            @enderror
                        </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Petunjuk Utama Section 2 :</span>
                            <textarea name="section_2_direction" id="section_2_direction" class="form-textarea mt-1 block w-full" rows="3" placeholder="Direction . . .">{{ $toefl->section_2_direction ?? old('section_2_direction') }}</textarea>
                            @error('section_2_direction')
                                <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                            @enderror
                        </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Petunjuk Utama Section 3 :</span>
                            <textarea name="section_3_direction" id="section_3_direction" class="form-textarea mt-1 block w-full" rows="3" placeholder="Direction . . .">{{ $toefl->section_3_direction ?? old('section_3_direction') }}</textarea>
                            @error('section_3_direction')
                                <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                            @enderror
                        </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Petunjuk SubSection Structure :</span>
                            <textarea name="structure_direction" id="structure_direction" class="form-textarea mt-1 block w-full" rows="3" placeholder="Direction . . .">{{ $toefl->structure_direction ?? old('structure_direction') }}</textarea>
                            @error('structure_direction')
                                <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                            @enderror
                        </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Petunjuk SubSection Written Expression :</span>
                            <textarea name="written_expression_direction" id="written_expression_direction" class="form-textarea mt-1 block w-full" rows="3" placeholder="Direction . . .">{{ $toefl->written_expression_direction ?? old('written_expression_direction') }}</textarea>
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
