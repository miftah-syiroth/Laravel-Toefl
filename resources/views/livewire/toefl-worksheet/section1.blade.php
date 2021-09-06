<div>
    <div class="flex py-2 px-2">
        <div class="border rounded-xl py-2 px-6 w-full mr-2">
            {{-- ini untuk menampilkan direction --}}
            <img src="{{ asset('/storage/' . $direction) }}" alt="gambar passage" class="shadow-xl my-4">

        </div>

        <div class="border rounded-xl py-2 px-2 max-w-3/4 w-3/4 ml-2">
            <div class="flex flex-col">
                <div wire:poll.visible="countdown" class="mb-4">
                    <p class="text-right font-semibold">waktu anda tersisa {{ $menit }} menit {{ $detik }} detik</p>
                </div>
                <div> 
                    <audio hidden controls autoplay src="{{ asset('/storage/'. $toefl->section_1_track) }}">
                        Your browser does not support the audio element.
                        <code>audio</code> element.
                    </audio>
                </div>

                <div class="border rounded-xl py-2 px-6 w-full mr-2">
                    <div class="mt-4 max-w-md">
                        <div>
                            <p class="text-right">No. {{ $index+1 }} / 50</p>
                        </div>
                        <div class="grid grid-cols-1 gap-6">
                            <form wire:submit.prevent="saveAnswer">
                                <div class="block mt-2">
                                    <span class="text-gray-700">Listen Audio and Select The Best Answer Below</span>
                                    @error('answer')
                                        <div class="text-red-600 text-sm font-weight-bold">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input wire:model="answer" class="form-radio" type="radio" name="radio-direct" value="1" />
                                                <span class="ml-2">{{ $question->option_a }}</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input wire:model="answer" class="form-radio" type="radio" name="radio-direct" value="2" />
                                                <span class="ml-2">{{ $question->option_b }}</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input wire:model="answer" class="form-radio" type="radio" name="radio-direct" value="3" />
                                                <span class="ml-2">{{ $question->option_c }}</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input wire:model="answer" class="form-radio" type="radio" name="radio-direct" value="4" />
                                                <span class="ml-2">{{ $question->option_d }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="block mt-2">
                                    <button type="submit" class="py-1 px-2 bg-indigo-600 rounded-lg text-white">{{ $index+1 == count($arrayOfQuestions) ? 'simpan dan lanjut section 2' : 'simpan jawaban' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>
