<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('CREATE TOEFLS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="/admin/toefls" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <div class="grid grid-cols-3 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="title" class="block font-medium text-gray-700">
                                            Judul Toefl
                                            </label>
                                            @error('title')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300 @error('title') is-invalid @enderror">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-2 rounded-lg p-2">
                                        <div>
                                            <h3 class="font-semibold text-lg text-center">Section 1</h3>
                                        </div>
                                        <div class="py-2 border-b">
                                            <label for="about" class="block font-medium text-gray-900">
                                                Audio Full Listening Comprehension
                                            </label>
                                            @error('section_1_track')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="section_1_track" id="section_1_track" value="{{ old('section_1_track') }}" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>
                                        </div>

                                        {{-- <div class="py-2 border-b">
                                            <label for="part_a_track" class="block font-medium text-gray-900">
                                                Audio Part A
                                            </label>
                                            @error('part_a_track')
                                                <div class="text-red-600 text-sm font-weight-bold">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="part_a_track" id="part_a_track" value="{{ old('part_a_track') }}" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>                                            
                                        </div>

                                        <div class="py-2 border-b">
                                            <label for="part_b_track" class="block font-medium text-gray-900">
                                                Audio Part B
                                            </label>
                                            @error('part_b_track')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="part_b_track" id="part_b_track" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>
                                        </div>

                                        <div class="py-2 border-b">
                                            <label for="part_c_track" class="block font-medium text-gray-900">
                                                Audio Part C
                                            </label>
                                            @error('part_c_track')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="part_c_track" id="part_c_track" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>                                            
                                        </div> --}}

                                        {{-- <div class="py-2 border-b">
                                            <label for="section_1_direction" class="block font-medium text-gray-700">
                                                Petunjuk Teks Section 1
                                            </label>
                                            @error('section_1_direction')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <textarea id="section_1_direction" name="section_1_direction" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('section_1_direction') }}</textarea>
                                            </div>
                                            
                                        </div> --}}

                                        {{-- <div class="py-2 border-b">
                                            <label for="part_a_direction" class="block font-medium text-gray-700">
                                                Petunjuk Teks Part A
                                            </label>
                                            @error('part_a_direction')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <textarea id="part_a_direction" name="part_a_direction" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('part_a_direction') }}</textarea>
                                            </div>
                                            
                                        </div> --}}

                                        {{-- <div class="py-2 border-b">
                                            <label for="part_b_direction" class="block font-medium text-gray-700">
                                                Petunjuk Teks Part B
                                            </label>
                                            @error('part_b_direction')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <textarea id="part_b_direction" name="part_b_direction" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('part_b_direction') }}</textarea>
                                            </div>
                                            
                                        </div> --}}

                                        {{-- <div class="py-2 border-b">
                                            <label for="part_c_direction" class="block font-medium text-gray-700">
                                                Petunjuk Teks Part C
                                            </label>
                                            @error('part_c_direction')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <textarea id="part_c_direction" name="part_c_direction" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('part_c_direction') }}</textarea>
                                            </div>
                                            
                                        </div> --}}

                                        <div class="py-2">
                                            <label for="section_1_imageable" class="block font-medium text-gray-700">
                                                Gambar Petunjuk Section 1
                                            </label>
                                            @error('section_1_imageable')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="section_1_imageable" id="section_1_imageable" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>
                                            
                                        </div>

                                        <div class="py-2">
                                            <label for="part_a_imageable" class="block font-medium text-gray-700">
                                                Gambar Petunjuk Part A
                                            </label>
                                            @error('part_a_imageable')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="part_a_imageable" id="part_a_imageable" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>
                                            
                                        </div>

                                        <div class="py-2">
                                            <label for="part_b_imageable" class="block font-medium text-gray-700">
                                                Gambar Petunjuk Part B
                                            </label>
                                            @error('part_b_imageable')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="part_b_imageable" id="part_b_imageable" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>
                                            
                                        </div>

                                        <div class="py-2">
                                            <label for="part_c_imageable" class="block font-medium text-gray-700">
                                                Gambar Petunjuk Part C
                                            </label>
                                            @error('part_c_imageable')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="part_c_imageable" id="part_c_imageable" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    

                                    <div class="border-2 rounded-lg p-2">
                                        <div>
                                            <h3 class="font-semibold text-lg text-center">Section 2</h3>
                                        </div>

                                        {{-- <div class="py-2 border-b">
                                            <label for="section_2_direction" class="block font-medium text-gray-700">
                                                Petunjuk Teks Section 2
                                            </label>
                                            @error('section_2_direction')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <textarea id="section_2_direction" name="section_2_direction" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('section_2_direction') }}</textarea>
                                            </div>
                                            
                                        </div> --}}

                                        {{-- <div class="py-2 border-b">
                                            <label for="structure_direction" class="block font-medium text-gray-700">
                                                Petunjuk Teks Structure
                                            </label>
                                            @error('structure_direction')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <textarea id="structure_direction" name="structure_direction" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('structure_direction') }}</textarea>
                                            </div>
                                            
                                        </div> --}}

                                        {{-- <div class="py-2 border-b">
                                            <label for="written_expression_direction" class="block font-medium text-gray-700">
                                                Petunjuk Teks Written Expression
                                            </label>
                                            @error('written_expression_direction')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <textarea id="written_expression_direction" name="written_expression_direction" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('written_expression_direction') }}</textarea>
                                            </div>
                                            
                                        </div> --}}

                                        <div class="py-2">
                                            <label for="section_2_imageable" class="block font-medium text-gray-700">
                                                Gambar Petunjuk Section 2
                                            </label>
                                            @error('section_2_imageable')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="section_2_imageable" id="section_2_imageable" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>
                                            
                                        </div>

                                        <div class="py-2">
                                            <label for="structure_imageable" class="block font-medium text-gray-700">
                                                Gambar Petunjuk Structure
                                            </label>
                                            @error('structure_imageable')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="structure_imageable" id="structure_imageable" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>
                                            
                                        </div>

                                        <div class="py-2">
                                            <label for="written_expression_imageable" class="block font-medium text-gray-700">
                                                Gambar Petunjuk Written Expression
                                            </label>
                                            @error('written_expression_imageable')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="written_expression_imageable" id="written_expression_imageable" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="border-2 rounded-lg p-2">
                                        <div>
                                            <h3 class="font-semibold text-lg text-center">Section 3</h3>
                                        </div>

                                        {{-- <div class="py-2 border-b">
                                            <label for="section_3_direction" class="block font-medium text-gray-700">
                                                Petunjuk Teks Section 3
                                            </label>
                                            @error('section_3_direction')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <textarea id="section_3_direction" name="section_3_direction" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('section_3_direction') }}</textarea>
                                            </div>
                                            
                                        </div> --}}

                                        <div class="py-2">
                                            <label for="section_3_imageable" class="block font-medium text-gray-700">
                                                Gambar Petunjuk Section 3
                                            </label>
                                            @error('section_3_imageable')
                                                <div class="text-red-600 font-weight-bold text-sm">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-1">
                                                <input type="file" name="section_3_imageable" id="section_3_imageable" class="form-input mt-1 block w-full" placeholder="Jane Doe">
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>       
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            ClassicEditor
                .create( document.querySelector( '#section_1_direction' ) )
                .catch( error => {
                    console.error( error );
                } );

            ClassicEditor
                .create( document.querySelector( '#part_a_direction' ) )
                .catch( error => {
                    console.error( error );
                } );

            ClassicEditor
                .create( document.querySelector( '#part_b_direction' ) )
                .catch( error => {
                    console.error( error );
                } );

            ClassicEditor
                .create( document.querySelector( '#part_c_direction' ) )
                .catch( error => {
                    console.error( error );
                } );
               
            ClassicEditor
                .create( document.querySelector( '#section_2_direction' ) )
                .catch( error => {
                    console.error( error );
                } );

            ClassicEditor
                .create( document.querySelector( '#structure_direction' ) )
                .catch( error => {
                    console.error( error );
                } );

            ClassicEditor
                .create( document.querySelector( '#written_expression_direction' ) )
                .catch( error => {
                    console.error( error );
                } );

            ClassicEditor
                .create( document.querySelector( '#section_3_direction' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>
    @endpush
</x-app-layout>