<div>
    <div class="flex py-2 px-2">
        <div class="border rounded-xl py-2 px-6 w-full mr-2">
            {{-- ini untuk menampilkan direction --}}
            <img src="{{ asset('/storage/' . $direction) }}" alt="gambar passage" class="shadow-xl my-4 w-full">

        </div>

        <div class="border rounded-xl py-2 px-2 max-w-3/4 w-3/4 ml-2">
            <div class="flex flex-col">
                <div wire:poll.visible="countdown" class="mb-4">
                    <p class="text-right font-semibold">waktu anda tersisa {{ $menit }} menit {{ $detik }} detik</p>
                </div>

                <div class="border rounded-xl py-2 px-6 w-full mr-2">
                    <div class="mt-4 max-w-md">
                        <div class="flex flex-row justify-between">
                            <p class="font-semibold">{{ $sub_section->name }}</p>
                            <p class="text-right font-semibold">No. {{ $index+1 }} / 40</p>
                        </div>
                        <div class="grid grid-cols-1 gap-3">
                            <form wire:submit.prevent="save">
                                <div class="block mt-2">
                                    @error('answer')
                                        <div class="text-red-600 text-sm font-weight-bold">{{ $message }}</div>
                                    @enderror
                                    <label class="block mt-2 mb-2 shadow-xl bg-gray-100 rounded-lg">

                                    @if ($question_selected)
                                    
                                        @if ($sub_section->id == 1)
                                        <p>{{ $question_selected->question }}</p>
                                        @else
                                        <img src="{{ asset('/storage/' . $question_selected->written_expression_imageable) }}" alt="gambar passage" class="shadow-xl my-4 w-full">
                                        @endif
                                        
                                    @else

                                        @if ($sub_section->id == 1)
                                        <p>{{ $question->question }}</p>
                                        @else
                                        <img src="{{ asset('/storage/' . $question->written_expression_imageable) }}" alt="gambar passage" class="shadow-xl my-4 w-full">
                                        @endif
                                    
                                    @endif
                                        
                                    </label>
                                    
                                    <div class="mt-5">
                                        <div class="mt-2">
                                            <label class="inline-flex items-center">
                                                <input wire:model="answer" class="form-radio" type="radio" name="radio-direct" value="1" />
                                                <span class="ml-2">{{ $question_selected ? $question_selected->option_a : $question->option_a }}</span>
                                            </label>
                                        </div>
                                        <div class="mt-2">
                                            <label class="inline-flex items-center">
                                                <input wire:model="answer" class="form-radio" type="radio" name="radio-direct" value="2" />
                                                <span class="ml-2">{{ $question_selected ? $question_selected->option_b : $question->option_b }}</span>
                                            </label>
                                        </div>
                                        <div class="mt-2">
                                            <label class="inline-flex items-center">
                                                <input wire:model="answer" class="form-radio" type="radio" name="radio-direct" value="3" />
                                                <span class="ml-2">{{ $question_selected ? $question_selected->option_c : $question->option_c }}</span>
                                            </label>
                                        </div>
                                        <div class="mt-2">
                                            <label class="inline-flex items-center">
                                                <input wire:model="answer" class="form-radio" type="radio" name="radio-direct" value="4" />
                                                <span class="ml-2">{{ $question_selected ? $question_selected->option_d : $question->option_d }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="block mt-2">
                                    <button type="submit" class="py-1 px-2 bg-indigo-600 rounded-lg text-white">{{ $index+1 == count($arrayOfQuestions) ? 'simpan dan lanjut section 3' : 'simpan jawaban' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="border rounded-xl py-2 px-6 mr-2 mt-2">
                    @foreach ($questions_answered as $key => $question)
                    {{-- question berisi id soal, key berisi index array --}}
                    <button wire:click="selectQuestion({{ $question }}, {{ $key }})" class="bg-gray-200 h-8 w-8 border-2 ml-2 my-2 text-sm hover:bg-gray-400">{{ $key+1 }}</button>
                    @endforeach
                    <button wire:click="lastQuestion" class="{{ $question_selected ? 'bg-gray-200' : 'bg-indigo-500 text-white' }} h-8 w-8 border-2 ml-2 my-2 text-sm hover:bg-gray-400">{{ $questions_answered->count() + 1 }}</button> <-- soal terakhir
                </div>
            </div>
            
        </div>
    </div>
</div>
