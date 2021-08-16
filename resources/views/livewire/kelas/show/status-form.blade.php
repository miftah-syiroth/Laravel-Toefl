<div>
    <div>
        <h1>Status : {{ $status }}</h1>
    </div>
    <div>
    @foreach ($statuses as $key => $status)
        <button wire:click="changeStatus({{ $status->id }})" class="px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-gray-500 hover:bg-indigo-300 md:py-4 md:text-lg md:px-10 ml-4">{{ $status->status }}</button>
    @endforeach
    </div>
</div>
