<x-layouts.pendaftar>
    <x-slot name="heading">
        <div class="grow">
            <h1 class="text-2xl font-semibold">Dashboard</h1>
        </div>
    </x-slot>

    @livewire('pendaftar.papan-pengumuman-component')

    {{-- @livewire('pendaftar.pendaftaran-baru-component') --}}

    @foreach ($pendaftaran as $record)
        <livewire:pendaftar.pendaftaran-saya-component :pendaftaran="$record" />
    @endforeach

</x-layouts.pendaftar>
