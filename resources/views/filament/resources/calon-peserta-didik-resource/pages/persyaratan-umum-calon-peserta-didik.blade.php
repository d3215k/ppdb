<x-filament-panels::page>
    <div class="py-4">
        <form wire:submit="handleSubmit" class="space-y-6">
            {{ $this->form }}

            <div class="mt-4 flex justify-between">
                <x-filament::button type="submit">
                    Simpan
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
