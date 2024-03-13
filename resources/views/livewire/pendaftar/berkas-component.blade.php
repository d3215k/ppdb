{{-- <x-card> --}}
    <div class="py-4">
        <form wire:submit="handleSubmit" class="space-y-6">
            <x-filament::section heading="Persyaratan Umum">
                {{ $this->persyaratanUmumForm }}
            </x-filament::section>

            <x-filament::section heading="Persyaratan Khusus">
                {{ $this->persyaratanKhususForm }}
            </x-filament::section>


            <x-filament::button type="submit" class="mt-4">
                Simpan
            </x-filament::button>
        </form>
        <x-filament-actions::modals />
    </div>
{{-- </x-card> --}}
