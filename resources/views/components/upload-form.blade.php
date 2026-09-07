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
      enctype="multipart/form-data" class="flex items-center justify-center w-full">
    @csrf

    {{-- `dragover.prevent` is what makes the label a valid drop target. --}}
    <label for="torrent"
           x-on:dragover.prevent="dragging = true"
           x-on:dragleave.prevent="dragging = false"
           x-on:drop.prevent="drop($event)"
           :class="dragging && 'ring-2 ring-purple-500 dark:ring-purple-400'"
           class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
        {{-- Ignore pointer events so dragging over the text does not fire `dragleave`. --}}
        <div class="pointer-events-none flex flex-col items-center justify-center pt-5 pb-6">
            <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                <span class="font-semibold">Click to upload</span> or drag and drop</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">TORRENT (MAX. 10MB)</p>
        </div>
        <input id="torrent" x-ref="torrent" name="torrent" type="file" accept=".torrent" class="hidden"
               x-on:change.prevent="$refs.uploadForm.submit()"/>
    </label>
</form>
