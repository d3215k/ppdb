<div class="relative bg-white shadow-sm">
    <!-- Ribbon -->
    <div class="absolute -right-2.5 -top-2.5 z-10 size-28 overflow-hidden">
        <span class="absolute top-0 size-2.5 bg-red-900"></span>
        <span class="absolute bottom-0 right-0 size-2.5 bg-red-900"></span>
        <a href="javascript:void(0)"
            class="absolute bottom-0 right-0 flex w-[calc(100%*1.4142)] origin-bottom-right rotate-45 items-center justify-center gap-1.5 bg-red-600 p-2.5 text-center text-sm leading-tight text-white hover:bg-red-700 active:bg-red-600"
        >
            <span class="text-xs uppercase font-semibold">Belum Lengkap</span>
        </a>
    </div>
    <!-- END Ribbon -->

    <div class="bg-gray-50 px-5 py-4">
        <h3 class="mb-1 text-xl font-semibold">Pendaftaran PPDB Tahun {{ session('tahun_pelajaran') }}</h3>
    </div>

    <div class="px-5 py-2 text-sm">
        <dl class="divide-y divide-gray-100">
            <x-item-list title="Nama Lengkap" description="{{ $pendaftaran->calonPesertaDidik->nama }}" />
            <x-item-list title="NISN" description="{{ $pendaftaran->calonPesertaDidik->nisn }}" />
            <x-item-list title="Asal Sekolah" description="{{ $pendaftaran->calonPesertaDidik->asalSekolah->nama ?? '-' }}" />
            <x-item-list title="Gelombang" description="{{ $pendaftaran->gelombang->nama }}" />
            <x-item-list title="Jalur" description="{{ $pendaftaran->jalur->nama }}" />
            <x-item-list title="Pilihan Jurusan Pertama" description="{{ $pendaftaran->pilihanKesatu->nama }}" />
            <x-item-list title="Pilihan Jurusan Kedua" description="{{ $pendaftaran->pilihanKedua->nama }}" />
            <x-item-list title="Tanggal Mendaftar" description="{{ $pendaftaran->created_at->isoFormat('dddd, D MMMM Y H:m') }}" />
        </dl>
    </div>

    <div class="bg-gray-50 px-5 py-4">
        <h3 class="mb-1 text-xl font-semibold">Alur Pendaftaran</h3>
        <h4 class="text-sm text-gray-500">
            Periksa kelengkapan dan alur pendaftaran melalui langkah berikut ini.
        </h4>
    </div>
    <div class="px-5">
        <div class="grid grid-cols-1 py-4 gap-4 md:grid-cols-4">
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
