<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flow-root">
            <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <table class="min-w-full border-separate border-spacing-0">
                        <thead>
                        <tr>
                            <th scope="col"
                                class="sticky top-0 z-10 border-b border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">
                                Hash
                            </th>
                            <th scope="col"
                                class="sticky top-0 z-10 hidden border-b border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 backdrop-blur backdrop-filter sm:table-cell">
                                Uploaded
                            </th>
                            <th scope="col"
                                class="sticky top-0 z-10 border-b border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 bg-opacity-75 py-3.5 pl-3 pr-4 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">
                                <span class="sr-only">Manage</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($torrents as $torrent)
                            <tr>
                                <td class="whitespace-nowrap border-b border-gray-200 dark:border-gray-800 py-4 pl-4 pr-3 text-sm font-medium sm:pl-6 lg:pl-8">
                                    {{ $torrent->filename ?? $torrent->hash }}
                                </td>
                                <td class="whitespace-nowrap border-b border-gray-200 dark:border-gray-800 hidden px-3 py-4 text-sm text-gray-500 dark:text-gray-400 sm:table-cell">
                                    {{ $torrent->created_at->diffForHumans() }}
                                </td>
                                <td class="relative whitespace-nowrap border-b border-gray-200 dark:border-gray-800 py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-8 lg:pr-8">
                                    <a href="{{ route('details', $torrent) }}"
                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-100">View<span
                                            class="sr-only">, {{ $torrent->filename }}</span></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{ $torrents->links() }}
</div>
