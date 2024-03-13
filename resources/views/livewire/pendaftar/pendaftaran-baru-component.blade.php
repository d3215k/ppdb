<x-card heading="Daftar PPDB">
    <div class="py-4">
        <form wire:submit="handleSubmit">
            {{ $this->form }}
        </form>

        <x-filament-actions::modals />
    </div>
</x-card>
