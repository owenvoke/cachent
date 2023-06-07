<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-2 sm:px-6 lg:px-8">
            <x-banner class="mb-2"></x-banner>
            <x-validation-errors class="mb-2"></x-validation-errors>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <x-upload-form></x-upload-form>
            </div>

            @auth
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mt-8">
                    <livewire:uploaded-torrents></livewire:uploaded-torrents>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>
