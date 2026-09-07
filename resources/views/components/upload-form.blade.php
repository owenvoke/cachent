<form x-data="{
          dragging: false,

          drop(event) {
              this.dragging = false

              const [file] = event.dataTransfer.files

              if (! file) return

              // The input is not `multiple`, so only hand it the first file.
              const transfer = new DataTransfer()
              transfer.items.add(file)
              this.$refs.torrent.files = transfer.files

              this.$refs.uploadForm.submit()
          },
      }"
      x-ref="uploadForm" action="{{ route('upload') }}" method="post"
      enctype="multipart/form-data" class="flex w-full items-center justify-center">
    @csrf

    {{-- `dragover.prevent` is what makes the label a valid drop target. --}}
    <label for="torrent"
           x-on:dragover.prevent="dragging = true"
           x-on:dragleave.prevent="dragging = false"
           x-on:drop.prevent="drop($event)"
           :class="dragging && 'ring-2 ring-accent'"
           class="flex h-64 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-zinc-300 bg-zinc-50 hover:bg-zinc-100 dark:border-zinc-600 dark:bg-zinc-700 dark:hover:border-zinc-500 dark:hover:bg-zinc-600">
        {{-- Ignore pointer events so dragging over the text does not fire `dragleave`. --}}
        <div class="pointer-events-none flex flex-col items-center justify-center pt-5 pb-6">
            <flux:icon.cloud-arrow-up class="mb-3 size-10 text-zinc-400" />

            <flux:text class="mb-2">
                <span class="font-semibold">{{ __('Click to upload') }}</span> {{ __('or drag and drop') }}
            </flux:text>

            <flux:text size="sm">{{ __('TORRENT (MAX. 10MB)') }}</flux:text>
        </div>

        <input id="torrent" x-ref="torrent" name="torrent" type="file" accept=".torrent" class="hidden"
               x-on:change.prevent="$refs.uploadForm.submit()" />
    </label>
</form>
