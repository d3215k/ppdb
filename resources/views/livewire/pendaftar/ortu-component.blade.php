{{-- <x-card> --}}
    <div class="py-4">
        <div>
            <h3 class="text-lg font-semibold mb-4">Data Orang tua/Wali</h3>
        </div>
        <form wire:submit="handleSubmit">
            {{ $this->form }}

            <div class="mt-4 flex justify-between">
                <x-filament::button type="submit" :disabled="$this->calonPesertaDidik->locked">
                    Simpan
                </x-filament::button>
            </div>
        </form>
        <x-filament-actions::modals />
    </div>
{{-- </x-card> --}}
