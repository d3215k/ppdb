<x-layouts.pendaftar>
    <x-slot name="heading">
        <div class="grow">
            <h1 class="text-2xl font-semibold">Dashboard</h1>
        </div>
    </x-slot>

    <x-card heading="Pengumuman" description="Info penting yang jangan dilewatkan!">
        <div>
            <!-- Timeline: Simple -->
            <div class="relative py-5 dark:text-gray-100">
                <!-- Vertical Guide -->
                <div
                class="absolute bottom-0 left-0 top-0 flex w-10 flex-col justify-center md:w-12"
                aria-hidden="true"
                >
                <div
                    class="mx-auto h-2.5 w-1 grow-0 rounded-t bg-gradient-to-b from-transparent to-primary-100 dark:to-primary-900"
                ></div>
                <div class="mx-auto w-1 grow bg-primary-100 dark:bg-primary-900"></div>
                <div
                    class="mx-auto h-2.5 w-1 grow-0 rounded-b bg-gradient-to-t from-transparent to-primary-100 dark:to-primary-900"
                ></div>
                </div>
                <!-- END Vertical Guide -->

                <!-- Timeline -->
                <ul class="relative space-y-4 pl-10 md:pl-12">
                <!-- Event -->
                <li class="relative">
                    <div
                    class="absolute bottom-0 left-0 top-0 mt-5 flex w-10 -translate-x-full justify-center md:w-12"
                    >
                    <div
                        class="size-3 rounded-full bg-primary-500 ring ring-primary-100 ring-opacity-100 ring-offset-2 dark:bg-primary-300 dark:ring-primary-900 dark:ring-offset-gray-900"
                    ></div>
                    </div>
                    <div
                    class="rounded-xl bg-gray-100 p-4 hover:ring hover:ring-gray-100 hover:ring-offset-2 dark:bg-gray-800 dark:ring-offset-gray-900 dark:hover:ring-gray-700"
                    >
                    <h4 class="mb-2 font-semibold">3.0 update is now live!</h4>
                    <p class="text-sm leading-relaxed">
                        It's finally here are comes packed with many awesome features. Be sure
                        to
                        <a
                        href="javascript:void(0)"
                        class="font-medium text-primary-600 hover:text-primary-400 dark:text-primary-400 dark:hover:text-primary-300"
                        >download it</a
                        >
                        and let us know
                        <a
                        href="javascript:void(0)"
                        class="font-medium text-primary-600 hover:text-primary-400 dark:text-primary-400 dark:hover:text-primary-300"
                        >what you think</a
                        >!
                    </p>
                    </div>
                </li>
                <!-- END Event -->

                <!-- Event -->
                <li class="relative">
                    <div
                    class="absolute bottom-0 left-0 top-0 mt-5 flex w-10 -translate-x-full justify-center md:w-12"
                    >
                    <div
                        class="size-3 rounded-full bg-primary-500 ring ring-primary-100 ring-opacity-100 ring-offset-2 dark:bg-primary-300 dark:ring-primary-900 dark:ring-offset-gray-900"
                    ></div>
                    </div>
                    <div
                    class="rounded-xl bg-gray-100 p-4 hover:ring hover:ring-gray-100 hover:ring-offset-2 dark:bg-gray-800 dark:ring-offset-gray-900 dark:hover:ring-gray-700"
                    >
                    <h4 class="mb-2 font-semibold">Maintenance notice</h4>
                    <p class="text-sm leading-relaxed">
                        We are going to apply some security fixes next week. Please check out
                        the
                        <a
                        href="javascript:void(0)"
                        class="font-medium text-primary-600 hover:text-primary-400 dark:text-primary-400 dark:hover:text-primary-300"
                        >schedule</a
                        >
                        for more information about any downtime.
                    </p>
                    </div>
                </li>
                <!-- END Event -->

                </ul>
                <!-- END Timeline -->
            </div>
            <!-- END Timeline: Simple -->


        </div>
    </x-card>

    <x-card heading="Alur Pendaftaran" description="Periksa alur pendaftaran kalian melalui langkah berikut ini.">
        <!-- Statistics: Simple with Icons -->
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
        <!-- END Statistics: Simple with Icons -->

    </x-card>
</x-layouts.pendaftar>
