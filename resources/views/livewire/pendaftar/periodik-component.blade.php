{{-- <x-card> --}}
    <div class="py-4">
        <form wire:submit="handleSubmit">
            <div class="space-y-4">
                <x-filament::section heading="Data Periodik">
                    {{ $this->form }}
                </x-filament::section>
            </div>

            <div class="mt-4 flex justify-between">
                <x-filament::button type="submit">
                    Simpan
                </x-filament::button>
            </div>
        </form>
        <x-filament-actions::modals />
    </div>
{{-- </x-card> --}}
