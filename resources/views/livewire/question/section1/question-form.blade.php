<div>
    <div>
        <form wire:submit.prevent="save">
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

    @if ($questionSelected)
    <div>
        <button wire:click="delete" class="bg-red-600 py-2 px-2 rounded-lg">Hapus Soal</button>
    </div>
    @endif
</div>
