<div>
    <div wire:poll.1000ms="countdown">
        waktu anda tersisa {{ $menit }} menit {{ $detik }} detik
    </div>
    
    <div> {{-- ntar tambahin class hidden supaya ga bisa pause --}}
        <audio controls autoplay src="{{ asset('/storage/'. $toefl->section_1_track) }}">
            Your browser does not support the audio element.
            <code>audio</code> element.
        </audio>
    </div>
    <div>
        soal berdasarkan sub section
    </div>
    <div>
        <button class="py-1 px-2 bg-indigo-600 rounded-lg text-white">Next</button>
    </div>
    <div>
        <button class="py-1 px-2 bg-indigo-600 rounded-lg text-white">Akhiri</button>
    </div>
</div>
