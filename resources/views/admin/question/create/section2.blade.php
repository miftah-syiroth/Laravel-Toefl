<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('SHOW TOEFL : ') }} {{ $toefl->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="border-2 py-4">
                    <livewire:question.section2.sub-section-navigation :toefl="$toefl" :section="$section"/>
                </div>
                <div class="border-2 py-4">
                    <livewire:question.section2.question-form :toefl="$toefl" :section="$section"/>
                </div>
                <div class="border-2 py-4">
                    <livewire:question.section2.question-navigation :toefl="$toefl" :section="$section"/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
