<x-layouts::app :title="$torrent->filename ?? $torrent->hash">
    <div class="mx-auto w-full max-w-4xl space-y-6">
        <flux:card>
            <dl class="divide-y divide-zinc-200 dark:divide-zinc-700">
                <div class="grid gap-1 py-4 sm:grid-cols-3 sm:gap-4 first:pt-0">
                    <dt><flux:text>{{ __('Hash') }}</flux:text></dt>
                    <dd class="sm:col-span-2">
                        <flux:text class="font-mono break-all text-zinc-800 dark:text-white">{{ $torrent->hash }}</flux:text>
                    </dd>
                </div>

                <div class="grid gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                    <dt><flux:text>{{ __('Original Filename') }}</flux:text></dt>
                    <dd class="sm:col-span-2">
                        <flux:text class="break-all text-zinc-800 dark:text-white">{{ $torrent->filename ?? __('Unknown') }}</flux:text>
                    </dd>
                </div>

                <div class="grid gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                    <dt><flux:text>{{ __('Added') }}</flux:text></dt>
                    <dd class="sm:col-span-2">
                        <flux:text class="text-zinc-800 dark:text-white">{{ $torrent->created_at->diffForHumans() }}</flux:text>
                    </dd>
                </div>

                <div class="grid gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                    <dt><flux:text>{{ __('Size') }}</flux:text></dt>
                    <dd class="sm:col-span-2">
                        <flux:text class="text-zinc-800 dark:text-white">{{ Number::fileSize($torrent->size, precision: 2) }}</flux:text>
                    </dd>
                </div>

                <div class="grid gap-1 py-4 sm:grid-cols-3 sm:gap-4 last:pb-0">
                    <dt><flux:text>{{ __('Downloads') }}</flux:text></dt>
                    <dd class="sm:col-span-2">
                        <flux:text class="text-zinc-800 dark:text-white">{{ Number::format($torrent->downloads) }}</flux:text>
                    </dd>
                </div>
            </dl>
        </flux:card>

        {{-- Flux's copyable input replaces the hand-rolled clipboard button. --}}
        <flux:input
            readonly
            copyable
            icon="arrow-down-tray"
            class:input="font-mono"
            :label="__('Download link')"
            :value="route('download', ['torrent' => $torrent])"
        />
    </div>
</x-layouts::app>
