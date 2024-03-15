<x-filament-panels::page>
    <form wire:submit="handleSubmit" class="space-y-4">
        {{ $this->form }}

        <div class="mt-6 flex justify-between">
            <x-filament::button type="submit">
                Simpan
            </x-filament::button>
        </div>
    </form>
    <x-filament-actions::modals />
</x-filament-panels::page>
