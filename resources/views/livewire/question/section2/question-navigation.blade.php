<div>
    {{-- untuk navigasi soal, semoga berhasil --}}
    <div class="mt-3">
        <div class="flex flex-row flex-wrap">
            @foreach ($questions as $key => $question)
            {{-- {{ $question['id'] }} --}}
                <button wire:click="switchQuestion({{ $question['id'] }})" class="py-1 px-2 border-2 ml-2 my-2 bg-gray-200 hover:bg-gray-400">{{ $key + 1 }}</button>
            @endforeach
            <button wire:click="newQuestion" class="py-1 px-2 border-2 ml-2 my-2 bg-gray-200 hover:bg-gray-400">new</button>
        </div>
    </div>
</div>