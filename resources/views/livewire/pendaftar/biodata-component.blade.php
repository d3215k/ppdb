{{-- <x-card> --}}
    <div class="py-4">
        <form wire:submit="handleSubmit">
            <div class="space-y-4">
                <x-filament::section heading="Biodata">
                    {{ $this->calonPesertaDidikForm }}
                </x-filament::section>
            </div>

            <div class="mt-4 flex justify-between">
                <x-filament::button type="submit" :disabled="$this->calonPesertaDidik->locked">
                    Simpan
                </x-filament::button>
            </div>
        </form>
        <x-filament-actions::modals />
    </div>
{{-- </x-card> --}}
