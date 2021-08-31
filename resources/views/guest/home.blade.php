<x-guest-layout>
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                @role('admin')
                <a href="{{ url('/admin/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                @else
                <a href="{{ url('/participant/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                @endrole
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
            @endauth
        </div>
        @endif

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            
            @livewire('kelas.card-list')
        </div>
    </div>
</x-guest-layout>
