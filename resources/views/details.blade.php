<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 mb-4 shadow overflow-hidden rounded sm:rounded-lg">
                <div class="border-t border-gray-200 dark:border-gray-600 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200 sm:dark:divide-gray-600">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Hash</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2 text-ellipsis overflow-hidden">{{ $torrent->hash }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Original Filename</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2 text-ellipsis overflow-hidden">
                                {{ $torrent->filename ?? 'Unknown' }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Added</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                <time title="{{ $torrent->created_at }}"
                                      datetime="{{ $torrent->created_at }}">{{ $torrent->created_at->diffForHumans() }}</time>
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Size</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">{{ Rych\ByteSize\ByteSize::formatBinary($torrent->size) }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Downloads</dt>
                            <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">{{ $torrent->downloads }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div x-data>
                <div class="mt-2 flex rounded-md shadow-sm">
                    <div class="relative flex flex-grow items-stretch focus-within:z-10">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="h-5 w-5 text-gray-400" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                            </svg>
                        </div>
                        <label class="w-full">
                            <input readonly x-ref="downloadLink" onclick="this.select()"
                                   class="block w-full rounded-none rounded-l-md border-0 py-1.5 pl-10 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-50 outline-none ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-purple-200 dark:focus:ring-purple-800 sm:text-sm sm:leading-6"
                                   value="{{ route('download', ['torrent' => $torrent]) }}">
                        </label>
                    </div>
                    <button type="button" x-clipboard="$refs.downloadLink.value"
                            class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="-ml-0.5 h-5 w-5 text-gray-400" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                        </svg>
                        <span class="sr-only">Copy</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
