<x-layouts::app :title="__('Dashboard')">
    <div class="mx-auto w-full max-w-4xl space-y-8">
        @if ($errors->any())
            <flux:callout variant="danger" icon="exclamation-triangle" :heading="__('That torrent could not be uploaded')">
                <flux:callout.text>
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </flux:callout.text>
            </flux:callout>
        @endif

        <x-upload-form />

        @auth
            <livewire:uploaded-torrents />
        @endauth
    </div>
</x-layouts::app>
