<x-layouts.pendaftar>
    <x-slot name="heading">
        <div class="grow">
            <h1 class="text-2xl font-semibold">Biodata</h1>
        </div>
    </x-slot>

    <div class="space-y-4">
        <livewire:pendaftar.biodata-component lazy="on-load" />
        <livewire:pendaftar.ortu-component lazy="on-load">
        <livewire:pendaftar.periodik-component lazy="on-load">
    </div>

</x-layouts.pendaftar>
