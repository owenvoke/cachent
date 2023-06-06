<div class="flex flex-col sm:justify-center items-center py-12 bg-gray-50 dark:bg-gray-900">
    <div class="text-purple-600 dark:text-purple-300">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
