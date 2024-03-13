<div class="relative bg-white shadow-sm dark:bg-gray-900">
    <!-- Ribbon -->
    <div class="absolute -right-2.5 -top-2.5 z-10 size-28 overflow-hidden">
        <span class="absolute top-0 size-2.5 bg-red-900"></span>
        <span class="absolute bottom-0 right-0 size-2.5 bg-red-900"></span>
        <a
            href="javascript:void(0)"
            class="absolute bottom-0 right-0 flex w-[calc(100%*1.4142)] origin-bottom-right rotate-45 items-center justify-center gap-1.5 bg-red-600 p-2.5 text-center text-sm leading-tight text-white hover:bg-red-700 active:bg-red-600"
        >
            <span class="text-xs uppercase font-semibold">Belum Lengkap</span>
        </a>
    </div>
    <!-- END Ribbon -->

    <div class="bg-gray-50 px-5 py-4 dark:bg-gray-700/50">
        <h3 class="mb-1 text-xl font-semibold">Alur Pendaftaran</h3>
        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Periksa alur pendaftaran kalian melalui langkah berikut ini.
        </h4>
    </div>
    <div class="px-5">
        <div class="grid grid-cols-1 py-4 gap-4 md:grid-cols-4">
            <x-card-alur
                heading="Gelombang"
                description="Pilih Jalur Pendaftaran"
                isComplete
            />
            <x-card-alur
                heading="Data Identitas"
                description="Isi data profil diri"
            />
        </div>
    </div>
</div>
