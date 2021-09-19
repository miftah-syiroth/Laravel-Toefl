<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ $toefl->title }} / {{ __('Section 1 "Listening Comprehension" ') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-2">
                <a href="/admin/toefls/{{ $toefl->id }}" type="submit" class="rounded-lg px-3 py-1 bg-indigo-600 text-white hover:bg-red-300">Kembali</a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6">
                <div class="flex flex-row">
                    <div class="border rounded-xl py-2 px-6 w-full mr-2">
                        
                        <p class="text-right">
                            {{ $sub_section->name }} 
                            @unless ($question_selected) No. {{ $questions->count() + 1 }} @endunless
                        </p>
                        @if (session()->has('message'))
                            <div class="font-semibold text-red-600">
                                {{ session('message') }}
                            </div>
                        @endif
                        
                        <div class="mt-4 max-w-md">
                            <div class="grid grid-cols-1 gap-6">
                                <form wire:submit.prevent="save">
                                    <label class="block mt-2">
                                        <span class="text-gray-700">Option A</span>
                                        @error('option_a')
                                            <div class="text-red-600 text-sm font-weight-bold">{{ $message }}</div>
                                        @enderror
                                        <input type="text" wire:model="option_a" class="mt-0 block w-full px-0.5 border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-black"/>
                                    </label>
                                    <label class="block mt-2">
                                        <span class="text-gray-700">Option B</span>
                                        @error('option_b')
                                            <div class="text-red-600 text-sm font-weight-bold">{{ $message }}</div>
                                        @enderror
                                        <input type="text" wire:model="option_b" class="mt-0 block w-full px-0.5 border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-black"/>
                                    </label>
                                    <label class="block mt-2">
                                        <span class="text-gray-700">Option C</span>
                                        @error('option_c')
                                            <div class="text-red-600 text-sm font-weight-bold">{{ $message }}</div>
                                        @enderror
                                        <input type="text" wire:model="option_c" class="mt-0 block w-full px-0.5 border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-black"/>
                                    </label>
                                    <label class="block mt-2">
                                        <span class="text-gray-700">Option D</span>
                                        @error('option_d')
                                            <div class="text-red-600 text-sm font-weight-bold">{{ $message }}</div>
                                        @enderror
                                        <input type="text" wire:model="option_d" class="mt-0 block w-full px-0.5 border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-black"/>
                                    </label>
                                    <div class="block mt-2">
                                        <span class="text-gray-700">Jawaban Benar</span>
                                        @error('key_answer')
                                            <div class="text-red-600 text-sm font-weight-bold">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-2">
                                            <div>
                                                <label class="inline-flex items-center">
                                                    <input wire:model="key_answer" class="form-radio" type="radio" name="radio-direct" value="1" />
                                                    <span class="ml-2">Option A</span>
                                                </label>
                                            </div>
                                            <div>
                                                <label class="inline-flex items-center">
                                                    <input wire:model="key_answer" class="form-radio" type="radio" name="radio-direct" value="2" />
                                                    <span class="ml-2">Option B</span>
                                                </label>
                                            </div>
                                            <div>
                                                <label class="inline-flex items-center">
                                                    <input wire:model="key_answer" class="form-radio" type="radio" name="radio-direct" value="3" />
                                                    <span class="ml-2">Option C</span>
                                                </label>
                                            </div>
                                            <div>
                                                <label class="inline-flex items-center">
                                                    <input wire:model="key_answer" class="form-radio" type="radio" name="radio-direct" value="4" />
                                                    <span class="ml-2">Option D</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($isComplete == false || $question_selected)
                                    <div class="block mt-2">
                                        <button type="submit" class="py-1 px-2 bg-indigo-600 rounded-lg text-white">{{ $questions->count() < 50 ? 'simpan' : 'selesai' }}</button>
                                    </div>
                                    @endif
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded-xl py-2 px-2 w-60 ml-2">
                        <div>
                        @if ($question_selected)
                            @foreach ($questions as $key => $question)
                            <button wire:click="selectQuestion({{ $question->id }})" class="{{ $question_selected->id == $question->id ? 'bg-gray-500' : 'bg-gray-200' }} h-8 w-8 border-2 ml-2 my-2 text-sm hover:bg-gray-400">{{ $key+1 }}</button>
                            @endforeach
                        @else
                            @foreach ($questions as $key => $question)
                            <button wire:click="selectQuestion({{ $question->id }})" class="bg-gray-200 h-8 w-8 border-2 ml-2 my-2 text-sm hover:bg-gray-400">{{ $key+1 }}</button>
                            @endforeach
                        @endif
                        </div>

                        {{-- cegah supaya ga muncul ketika soal sudah lengkap 50--}}
                        @if (! $isComplete)
                        <div class="ml-2">
                            <button wire:click="newQuestion" class="text-indigo-500 underline hover:bg-in">new</button>
                        </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
