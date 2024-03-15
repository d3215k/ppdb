<x-filament-panels::page>
    <form wire:submit="handleSubmit" class="space-y-6">

        {{ $this->form }}

        <div class="mt-4 flex justify-between">
            <x-filament::button type="submit">
                Simpan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
