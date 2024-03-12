<!-- Card -->
@props([
    'isComplete' => false,
    'heading' => '',
    'description' => '',
])

<div
    @class([
        'flex flex-col overflow-hidden rounded-lg  border-1 border-gray-200 shadow-sm dark:bg-gray-800 dark:text-gray-100',
        'bg-gray-100' => !$isComplete,
        'bg-red-200' => $isComplete,
    ])>
    <div class="flex grow items-center justify-between p-5">
        <svg class="inline-block size-10 text-red-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
        <dl class="space-y-1 text-right">
        <dt class="text-lg font-semibold">{{ $heading }}</dt>
        <dd
            class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
        >
            {{ $description }}
        </dd>
        </dl>
    </div>
</div>
<!-- END Card -->
