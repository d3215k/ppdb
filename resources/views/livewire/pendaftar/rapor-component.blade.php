{{-- <x-card> --}}
    <div class="py-4">
        <form wire:submit="handleSubmit">
            <x-filament::section>
                {{ $this->form }}
            </x-filament::section>

            <div class="mt-4 flex justify-between">
                <x-filament::button type="submit">
                    Simpan
                </x-filament::button>
                <x-filament::button
                    outlined
                    href="{{ route('pendaftar.berkas') }}"
                    tag="a"
                    wire:navigate
                    color="gray"
                >
                    Berkas Persyaratan
                </x-filament::button>
            </div>
        </form>
        <x-filament-actions::modals />
    </div>
{{-- </x-card> --}}
