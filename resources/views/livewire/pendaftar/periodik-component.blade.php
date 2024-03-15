{{-- <x-card> --}}
    <div class="py-4">
        <form wire:submit="handleSubmit">
            <div class="space-y-4">
                <x-filament::section heading="Data Periodik dan Cek Fisik">
                    {{ $this->form }}
                </x-filament::section>
            </div>

            <div class="mt-4 flex justify-between">
                <x-filament::button type="submit" disabled="{{ $this->calonPesertaDidik->locked }}">
                    Simpan
                </x-filament::button>
                <x-filament::button
                    outlined
                    href="{{ route('pendaftar.rapor') }}"
                    tag="a"
                    wire:navigate
                    color="gray"
                >
                    Rapor
                </x-filament::button>
            </div>
        </form>
        <x-filament-actions::modals />
    </div>
{{-- </x-card> --}}
