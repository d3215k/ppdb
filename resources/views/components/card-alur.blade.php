<!-- Card -->
@props([
    'isComplete' => false,
    'heading' => '',
    'description' => '',
])

<div
    @class([
        'flex flex-col overflow-hidden border-1 border-gray-200 shadow-sm dark:bg-gray-800 dark:text-gray-100',
        'bg-gray-100' => !$isComplete,
        'bg-primary-600' => $isComplete,
    ])>
    <div class="flex grow items-center justify-between px-4 py-4">
        @if ($isComplete)
            <svg class="inline-block size-10 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
        @else
            <svg class="inline-block size-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        @endif
        <dl class="text-right">
            <dt
                @class([
                    'text-lg font-semibold',
                    'text-white' => $isComplete
                ])
            >
                {{ $heading }}
            </dt>
            <dd
                @class([
                    'text-xs font-semibold uppercase tracking-wider',
                    'text-gray-500 dark:text-gray-400' => !$isComplete,
                    'text-white' => $isComplete,
                ])
            >
                {{ $description }}
            </dd>
        </dl>
    </div>
</div>
<!-- END Card -->
