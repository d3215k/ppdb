<x-layouts.print>
    <div class="max-w-2xl mx-auto">
        @if ($setting->kop_surat)
        <div>
            <img src="{{ asset('storage/' . $setting->kop_surat) }}" />
        </div>
        @endif

        <div class="text-center mt-4 uppercase font-semibold text-xl">
            <h1>BUKTI PENGISIAN FORMULIR PENDATAAN</h1>
            <P>(INTERNAL) {{ $setting->nama }}</P>
            <p>TAHUN PELAJARAN {{ session('tahun_pelajaran') }}</p>
        </div>

        <div class="px-5 py-2 text-xl mt-12">
            <dl class="divide-y divide-red-50">
                <div class="px-0 py-2 text-red-600 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="leading-6 text-gray-700">Nomor Pendataan</dt>
                    <dd class="mt-1 leading-6 font-medium text-gray-900 sm:col-span-2 sm:mt-0">{{ $pendaftaran->nomor }}</dd>
                </div>
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
            </dl>
        </div>
    </div>

</x-layouts.print>
