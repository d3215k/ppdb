<div class="relative bg-white shadow-sm">
    <!-- Ribbon -->
    <div class="absolute -right-2.5 -top-2.5 z-10 size-28 overflow-hidden">
        <span @class(['absolute top-0 size-2.5', 'bg-red-900' => !$isComplete, 'bg-blue-900' => $isComplete])></span>
        <span @class(['absolute bottom-0 right-0 size-2.5', 'bg-red-900' => !$isComplete, 'bg-blue-900' => $isComplete])></span>
        <div
            @class([
                'absolute bottom-0 right-0 flex w-[calc(100%*1.4142)] origin-bottom-right rotate-45 items-center justify-center gap-1.5  p-2.5 text-center text-sm leading-tight text-white',
                'bg-red-600 hover:bg-red-700 active:bg-red-600' => !$isComplete,
                'bg-blue-600 hover:bg-blue-700 active:bg-blue-600' => $isComplete,
            ])
        >
            <span class="text-xs uppercase font-semibold">
                {{ $isComplete ? 'Lengkap' : 'Belum Lengkap' }}
            </span>
        </div>
    </div>
    <!-- END Ribbon -->

    <div class="bg-gray-50 px-5 py-4 md:items-center flex flex-col md:flex-row gap-4">
        <h3 class="text-xl font-semibold">Pendataan PPDB Tahun {{ session('tahun_pelajaran') }}</h3>
        <x-filament::button
            icon="heroicon-m-printer"
            href="{{ route('pendaftar.cetak', $pendaftaran->nomor) }}"
            tag="a"
            target="_blank"
        >
            Cetak Bukti Pendataan
        </x-filament::button>
    </div>

    <div class="px-5 py-2 text-sm">
        <dl class="divide-y divide-gray-100">
            <x-item-list title="Nomor Pendataan" description="{{ $pendaftaran->nomor }}" />
                <x-item-list title="Waktu Pendataan" description="{{ $pendaftaran->created_at->isoFormat('dddd, D MMMM Y H:m') }}" />
                    <x-item-list title="Nama Calon Siswa" description="{{ $pendaftaran->calonPesertaDidik->nama }}" />
                    <x-item-list title="Jenis Kelamin" description="{{ $pendaftaran->calonPesertaDidik->lp->getLabel() }}" />
                    <x-item-list title="Asal Sekolah" description="{{ $pendaftaran->calonPesertaDidik->asalSekolah?->nama ? $pendaftaran->calonPesertaDidik->asalSekolah?->nama : ($pendaftaran->calonPesertaDidik->asal_sekolah_temp ? $pendaftaran->calonPesertaDidik->asal_sekolah_temp : '-') }}" />
                    <x-item-list title="Nama Orang Tua" description="{{ $pendaftaran->calonPesertaDidik->ortu->lengkap ?? '-' }}" />
                    <x-item-list title="Alamat" description="{{ $pendaftaran->calonPesertaDidik->alamat_lengkap ?? '-' }}" />
                    <x-item-list title="No Handphone" description="{{ $pendaftaran->calonPesertaDidik->nomor_hp ?? '-' }}" />
                    <x-item-list title="No Handphone Orang Tua" description="{{ $pendaftaran->calonPesertaDidik->nomor_hp_ortu ?? '-' }}" />
                    <x-item-list title="Gelombang" description="{{ $pendaftaran->gelombang->nama }}" />
                    <x-item-list title="Jalur" description="{{ $pendaftaran->jalur->nama }}" />
                    <x-item-list title="Pilihan Jurusan Pertama" description="{{ $pendaftaran->pilihanKesatu->nama }}" />
                    <x-item-list title="Pilihan Jurusan Kedua" description="{{ $pendaftaran->pilihanKedua->nama }}" />
                    <x-item-list title="Email" description="{{ $pendaftaran->calonPesertaDidik->user->email }}" />
        </dl>
    </div>

    <div class="bg-gray-50 px-5 py-4">
        <h3 class="mb-1 text-xl font-semibold">Alur Pendataan</h3>
        <h4 class="text-sm text-gray-500">
            Periksa kelengkapan dan alur pendataan melalui langkah berikut ini.
        </h4>
    </div>
    <div class="px-5">
        <div class="grid grid-cols-1 py-4 gap-4 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($data as $item)
                <x-card-alur
                    heading="{{ $item['heading'] }}"
                    description="{{ $item['description'] }}"
                    isComplete="{{ $item['isComplete'] }}"
                    href="{{ $item['href'] }}"
                ></x-card-alur>
            @endforeach
        </div>
    </div>
</div>
