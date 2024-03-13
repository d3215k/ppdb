{{-- <x-card> --}}
    <div class="py-4">
        <form wire:submit="handleSubmit" class="space-y-6">
            <x-filament::section heading="Persyaratan Umum">
                {{ $this->persyaratanUmumForm }}
            </x-filament::section>

            <x-filament::section heading="Persyaratan Khusus">
                {{ $this->persyaratanKhususForm }}
            </x-filament::section>


            <div class="mt-4 flex justify-between">
                <x-filament::button type="submit">
                    Simpan
                </x-filament::button>
                <x-filament::button
                    outlined
                    href="{{ route('pendaftar.dashboard') }}"
                    tag="a"
                    wire:navigate
                    color="gray"
                >
                    Dashboard
                </x-filament::button>
            </div>
        </form>
        <x-filament-actions::modals />
    </div>
{{-- </x-card> --}}
