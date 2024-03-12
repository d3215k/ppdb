<div class="rounded-lg bg-white shadow-sm dark:bg-gray-900 overflow-hidden">
    <div class="bg-gray-50 px-5 py-4 dark:bg-gray-700/50">
        <h3 class="mb-1 text-xl font-semibold">{{ $heading ?? '' }}</h3>
        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">
          {{ $description ?? '' }}
        </h4>
    </div>
    <div class="px-5">
        {{ $slot }}
    </div>
</div>
