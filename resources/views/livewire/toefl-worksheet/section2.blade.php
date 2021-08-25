<div>
    <div wire:poll.visible="countdown">
        waktu anda tersisa {{ $menit }} menit {{ $detik }} detik
    </div>

    <div class="mt-6"><h1>Soal Nomor {{ $index+1 }} / {{ count($arrayOfQuestions) }}</h1></div>
    <div>
        <p>{{ $question->question }}</p>
    </div>
    <div class="flex flex-row mt-3">
        <div>
            <ul>
                <li>A. {{ $question->option_a }}</li>
                <li>B. {{ $question->option_b }}</li>
                <li>C. {{ $question->option_c }}</li>
                <li>D. {{ $question->option_d }}</li>
            </ul>
        </div>
        <div class="ml-6">
            <form wire:submit.prevent="saveAnswer" class="flex flex-row">
                <div>
                    @php
                    $val = 1
                    @endphp
                    @for ($i = 'A'; $i < 'E'; $i++)
                        <div>
                            <input type="radio" wire:model="answer" value="{{ $val }}" required>
                            <label for="html">{{ $i }}</label><br>
                        </div>
                    @php
                        $val++
                    @endphp
                    @endfor
                </div>
                
                <div>
                    <button type="submit" class="py-1 px-2 border-2 ml-2 my-2 text-white bg-indigo-600 hover:bg-gray-400">{{ $index+1 == count($arrayOfQuestions) ? 'simpan dan lanjut section 3' : 'simpan jawaban' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
