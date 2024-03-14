<x-filament::section heading="Formulir Pendaftaran {{ config('app.name') }} Tahun {{ session('tahun_pelajaran') }}">
    {{ $this->form }}

    <x-filament-actions::modals />
</x-filament::section>
