<div class="bg-white shadow-sm overflow-hidden">
    @isset($heading)
        <div class="bg-gray-50 px-5 py-4 dark:bg-gray-700/50">
            <h3 class="mb-1 text-xl font-semibold">{{ $heading }}</h3>
            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">
            {{ $description ?? '' }}
            </h4>
        </div>
    @endisset
    <div class="px-5">
        {{ $slot }}
    </div>
</div>
