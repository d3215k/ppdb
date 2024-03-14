{{-- <x-card> --}}
    <div class="py-4">
        <div>
            <h3 class="text-lg font-semibold mb-4">Data Orang tua/Wali</h3>
        </div>
        <form wire:submit="handleSubmit">
            {{ $this->form }}

            <div class="mt-4 flex justify-between">
                <x-filament::button type="submit">
                    Simpan
                </x-filament::button>
                {{-- <x-filament::button
                    outlined
                    href="{{ route('pendaftar.rapor') }}"
                    tag="a"
                    wire:navigate
                    color="gray"
                >
                    Data Rapor
                </x-filament::button> --}}
            </div>
        </form>
        <x-filament-actions::modals />
    </div>
{{-- </x-card> --}}
