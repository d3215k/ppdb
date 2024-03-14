<x-layouts.pendaftar>
    <x-slot name="heading">
        <div class="grow">
            <h1 class="text-2xl font-semibold">Dashboard</h1>
        </div>
    </x-slot>

    @if ($pengumuman->isNotEmpty())
        <livewire:pendaftar.papan-pengumuman-component lazy="on-load" />
    @endif

    @if ($pendaftaran)
        <livewire:pendaftar.pendaftaran-saya-component lazy="on-load" :pendaftaran="$pendaftaran" />
    @else
        @if ($gelombang->isNotEmpty())
            <livewire:pendaftar.pendaftaran-baru-component />
        @else
            <div>
                Tidak ada gelombang yang dibuka
            </div>
        @endif
    @endif


</x-layouts.pendaftar>
