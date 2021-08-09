<div>
    {{-- form untuk passage --}}
    <div class="border-2 py-4">
        <form wire:submit.prevent="savePassage">
            <div>
                <label for="passage">Passage : </label>
                <textarea wire:model="passage" name="narasion" id="naration" cols="60" rows="5" class="border-2"></textarea>
                @error('passage')
                    <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <button type="submit" class="bg-indigo-600 text-white px-2 py-1 rounded-lg">save narasi</button>
            </div>
        </form>

        @if ($passageSelected)
        <div>
            <button wire:click="deletePassage" class="bg-red-600 py-2 px-2 rounded-lg">Hapus Passage</button>
        </div>
        @endif
    </div>
    {{-- END form untuk passage --}}

    {{-- navigasi passage --}}
    <div class="border-2 py-4">
        <div class="flex flex-row flex-wrap">
            @foreach ($passages as $key => $passage)
                <button wire:click="switchPassage({{ $passage['id'] }})" class="py-1 px-2 border-2 ml-2 bg-gray-200 hover:bg-gray-400">{{ $key + 1 }}</button>
            @endforeach
            <button wire:click="newPassage" class="py-1 px-2 border-2 ml-4 bg-gray-200 hover:bg-gray-400">new</button>
        </div>
    </div>
    {{-- end navigasi passage --}}

    {{-- form untuk question --}}
    <div class="border-2 py-4">
        @if ($passageSelected)
        <div>
            <form wire:submit.prevent="saveQuestion">
                <div class="my-1">
                    <label for="question">question</label>
                    <textarea wire:model="question" name="question" id="question" cols="50" rows="5" class="border-2"></textarea>
                    @error('option_a')
                        <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div class="my-1">
                    <label for="option_a">option A :</label>
                    <input type="text" wire:model="option_a" class="border-2">
                    @error('option_a')
                        <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div class="my-1">
                    <label for="option_b">option B :</label>
                    <input type="text" wire:model="option_b" class="border-2">
                    @error('option_b')
                        <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div class="my-1">
                    <label for="option_c">option C :</label>
                    <input type="text" wire:model="option_c" class="border-2">
                    @error('option_c')
                        <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div class="my-1">
                    <label for="option_d">option D :</label>
                    <input type="text" wire:model="option_d" class="border-2">
                    @error('option_d')
                        <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div class="my-1">
                    <label for="key_answer">Kunci Jawaban :</label>
                    <select wire:model="key_answer">
                        <option>Select One!</option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                        <option value="3">C</option>
                        <option value="4">D</option>
                    </select>
                    @error('key_answer')
                        <div class="text-red-600 font-weight-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="py-1 px-2 bg-indigo-600 rounded-lg text-white">save</button>
                </div>
            </form>
        </div>
        @endif
    </div>
    {{-- end form question --}}

    {{-- navigasi question --}}
    <div class="border-2 py-4">
        @if ($questions)
        <div class="mt-3">
            <div class="flex flex-row flex-wrap">
                @foreach ($questions as $key => $question)
                    <button wire:click="switchQuestion({{ $question['id'] }})" class="py-1 px-2 border-2 ml-2 my-2 bg-gray-200 hover:bg-gray-400">{{ $key + 1 }}</button>
                @endforeach
                <button wire:click="newQuestion" class="py-1 px-2 border-2 ml-2 my-2 bg-gray-200 hover:bg-gray-400">new</button>
            </div>
        </div>
        @endif
    </div>
    {{-- end navigasi question --}}

</div>
