<div class="bg-white shadow-sm overflow-hidden">
    <div class="bg-gray-50 px-5 py-4 dark:bg-gray-700/50">
        <h3 class="mb-1 text-xl font-semibold">Pengumuman</h3>
        <h4 class="text-sm text-gray-500 dark:text-gray-400">
            Info penting yang jangan dilewatkan!
        </h4>
    </div>
    <div class="px-5">
        <div class="mb-4">
            <!-- Timeline: Simple -->
            <div class="relative py-5">
                <!-- Vertical Guide -->
                <div class="absolute bottom-0 left-0 top-0 flex w-10 flex-col justify-center md:w-12" aria-hidden="true">
                    <div class="mx-auto h-2.5 w-1 grow-0 rounded-t bg-gradient-to-b from-transparent to-gray-100"></div>
                    <div class="mx-auto w-1 grow bg-gray-100"></div>
                    <div class="mx-auto h-2.5 w-1 grow-0 rounded-b bg-gradient-to-t from-transparent to-gray-100"></div>
                </div>
                <!-- END Vertical Guide -->

                <!-- Timeline -->
                <ul class="relative space-y-12 pl-10 md:pl-12">
                    @foreach ($pengumuman as $item)
                        <!-- Event -->
                        <li class="relative">
                            <div
                            class="absolute bottom-0 left-0 top-0 mt-2 flex w-10 -translate-x-full justify-center md:w-12"
                            >
                                <div
                                    class="size-3 rounded-full bg-red-500 ring ring-red-100 ring-opacity-100 ring-offset-2 dark:bg-red-300 dark:ring-red-900 dark:ring-offset-gray-900"
                                ></div>
                            </div>
                            <div>
                                <div class="mb-2">
                                    <h4 class="font-semibold text-lg leading-tight">{{ $item->judul }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">Diterbitkan {{ $item->informan->name }} pada {{ $item->terbit->isoFormat('dddd, DD MMMM Y') }}</p>
                                </div>
                                <div class="space-y-4 text-sm prose max-w-screen-lg">
                                    {!! $item->isi !!}
                                </div>
                            </div>
                        </li>
                        <!-- END Event -->
                    @endforeach
                </ul>
                <!-- END Timeline -->
            </div>
            <!-- END Timeline: Simple -->

        </div>
    </div>
</div>
