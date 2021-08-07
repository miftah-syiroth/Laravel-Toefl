<div>
    {{-- form input narasi --}}
    <form wire:submit.prevent="saveNaration">
        <div>
            <label for="naration">Narasi : </label>
            <textarea wire:model="naration" name="narasion" id="naration" cols="60" rows="5" class="border-2"></textarea>
        </div>
        <div>
            <button type="submit" class="bg-blue-200 py-2 px-2 rounded-lg">save narasi</button>
        </div>
    </form>
</div>