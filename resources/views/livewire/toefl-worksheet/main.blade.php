<div>
    <p>komponen ini akan menampilkan semua informasi mengenai kelas dan toefl peserta yg akan mengerjakan, sedang atau sudah selesai</p>
   
    @if ($status == 1 || $status == 2 ) 
    <button wire:click="startToefl" class="py-1 px-2 bg-indigo-600 rounded-lg text-white">mulai soal</button>
    @else
        <p>sudah selesai</p>
    @endif
    
</div>
