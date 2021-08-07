<div>
    <form wire:submit.prevent="changeSubSection">
        <label class="block">
            <span>Select sub section : </span>
            <select wire:model="subSection">
                @foreach ($section->subSections as $subSection)
                <option value="{{ $subSection->id }}">{{ $subSection->name }}</option>
                @endforeach
            </select>
            <button class="py-1 px-2 bg-indigo-600 rounded-xl" type="submit">pilih</button>
        </label>
    </form>
</div>