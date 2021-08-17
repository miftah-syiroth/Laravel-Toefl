<div>
    @if ($content == 1)
        <div>
            <p>soal akan tersedia pada {{ $user->kelas->pelaksanaan }}</p>
            <button wire:click="startToefl" class="py-1 px-2 bg-indigo-600 rounded-lg text-white">Mulai Mengerjakan</button>
        </div>
    @elseif($content == 2)
        @livewire('toefl-worksheet.section1')
    @elseif($content == 3)
        @livewire('toefl-worksheet.section2')
    @else
        @livewire('toefl-worksheet.section3')
    @endif
</div>
