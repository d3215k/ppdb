<x-layouts.pendaftar>
    <x-slot name="heading">
        <div class="grow">
            <h1 class="text-2xl font-semibold">Biodata</h1>
        </div>
    </x-slot>

    <div class="space-y-4">
        @livewire('pendaftar.biodata-component')
        @livewire('pendaftar.ortu-component')
        @livewire('pendaftar.periodik-component')
    </div>

</x-layouts.pendaftar>
