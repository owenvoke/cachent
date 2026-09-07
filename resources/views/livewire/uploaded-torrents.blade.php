<div>
    <flux:table :paginate="$torrents">
        <flux:table.columns>
            <flux:table.column>{{ __('Torrent') }}</flux:table.column>
            <flux:table.column class="max-sm:hidden">{{ __('Uploaded') }}</flux:table.column>
            {{-- `sr-only` on the column itself collapses the cell, leaving the
                 header row narrower than the body rows. --}}
            <flux:table.column><span class="sr-only">{{ __('Manage') }}</span></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($torrents as $torrent)
                <flux:table.row :key="$torrent->id">
                    <flux:table.cell class="truncate">
                        {{ $torrent->filename ?? $torrent->hash }}
                    </flux:table.cell>

                    <flux:table.cell class="max-sm:hidden">
                        <flux:text>{{ $torrent->created_at->diffForHumans() }}</flux:text>
                    </flux:table.cell>

                    <flux:table.cell align="end">
                        <flux:link :href="route('details', $torrent)" wire:navigate>
                            {{ __('View') }}<span class="sr-only">, {{ $torrent->filename }}</span>
                        </flux:link>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="3">
                        <flux:text>{{ __('You have not uploaded any torrents.') }}</flux:text>
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>
