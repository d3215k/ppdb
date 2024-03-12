<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @filamentStyles
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body>
    <!-- Page Container -->
<div
    x-data="{ userDropdownOpen: false, mobileNavOpen: false }"
    id="page-container"
    class="mx-auto flex min-h-dvh w-full min-w-[320px] flex-col bg-gray-100 dark:bg-gray-800/50 dark:text-gray-100"
    >
    <!-- Page Header -->
    <header id="page-header" class="z-1 flex flex-none items-center bg-red-900">
    <div class="container mx-auto px-4 lg:px-8 xl:max-w-7xl">
        <div class="flex justify-between py-4">
        <!-- Left Section -->
        <div class="dark flex items-center space-x-2 lg:space-x-6">
            <!-- Logo -->
            <a
            href="javascript:void(0)"
            class="group inline-flex items-center space-x-2 text-lg font-bold tracking-wide text-gray-900 hover:text-gray-600 dark:text-gray-100 dark:hover:text-gray-300"
            >
                <span>{{ config('app.name') }}</span>
            </a>
            <!-- END Logo -->

            <!-- Desktop Navigation -->
            <nav class="hidden items-center space-x-2 lg:flex">
            <a
                href="javascript:void(0)"
                class="group flex items-center space-x-2 rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-sm font-medium text-red-600 dark:border-transparent dark:bg-white/10 dark:text-white"
            >
                <span>Dashboard</span>
            </a>
            <a
                href="javascript:void(0)"
                class="group flex items-center space-x-2 rounded-lg border border-transparent px-3 py-2 text-sm font-medium text-gray-800 hover:bg-red-50 hover:text-red-600 active:border-red-100 dark:text-gray-200 dark:hover:bg-white/10 dark:hover:text-white dark:active:border-white/20"
            >
                <span>Data Identitas</span>
            </a>
            <a
                href="javascript:void(0)"
                class="group flex items-center space-x-2 rounded-lg border border-transparent px-3 py-2 text-sm font-medium text-gray-800 hover:bg-red-50 hover:text-red-600 active:border-red-100 dark:text-gray-200 dark:hover:bg-white/10 dark:hover:text-white dark:active:border-white/20"
            >
                <span>Projects</span>
            </a>
            <a
                href="javascript:void(0)"
                class="group flex items-center space-x-2 rounded-lg border border-transparent px-3 py-2 text-sm font-medium text-gray-800 hover:bg-red-50 hover:text-red-600 active:border-red-100 dark:text-gray-200 dark:hover:bg-white/10 dark:hover:text-white dark:active:border-white/20"
            >
                <span>Sales</span>
            </a>
            </nav>
            <!-- END Desktop Navigation -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="flex items-center space-x-2">

            <!-- User Dropdown -->
            <div class="relative inline-block">
            <!-- Dropdown Toggle Button -->
            <div class="dark">
                <button
                x-on:click="userDropdownOpen = true"
                x-bind:aria-expanded="userDropdownOpen"
                type="button"
                id="tk-dropdown-layouts-user"
                class="inline-flex items-center justify-center space-x-2 px-3 py-2 text-sm font-semibold leading-5 text-red-800 rounded-lg hover:text-red-900 hover:shadow-sm focus:ring focus:ring-red-300 focus:ring-opacity-25 active:shadow-none dark:bg-transparent dark:text-gray-100 dark:hover:border-red-500 dark:hover:text-gray-50 dark:focus:ring-red-600 dark:focus:ring-opacity-60"
                aria-haspopup="true"
                >
                <svg
                    class="hi-mini hi-user-circle inline-block size-5 sm:hidden"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <path
                    fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"
                    clip-rule="evenodd"
                    />
                </svg>
                <span class="hidden sm:inline">John</span>
                <svg
                    class="hi-mini hi-chevron-down hidden size-5 opacity-40 sm:inline-block"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd"
                    />
                </svg>
                </button>
            </div>
            <!-- END Dropdown Toggle Button -->

            <!-- Dropdown -->
            <div
                x-cloak
                x-show="userDropdownOpen"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                x-on:click.outside="userDropdownOpen = false"
                role="menu"
                aria-labelledby="tk-dropdown-layouts-user"
                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-lg shadow-xl dark:shadow-gray-900"
            >
                <div
                class="divide-y divide-gray-100 rounded-lg bg-white ring-1 ring-black ring-opacity-5 dark:divide-gray-700 dark:bg-gray-800 dark:ring-gray-700"
                >
                <div class="space-y-1 p-2.5">
                    <a
                    role="menuitem"
                    href="javascript:void(0)"
                    class="group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-800 active:border-red-100 dark:text-gray-200 dark:hover:bg-gray-700/75 dark:hover:text-white dark:active:border-gray-600"
                    >
                        <svg
                            class="hi-mini hi-user-circle inline-block size-5 flex-none opacity-25 group-hover:opacity-50"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                            fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"
                            clip-rule="evenodd"
                            />
                    </svg>
                        <span class="grow">Profil</span>
                    </a>
                </div>
                <div class="space-y-1 p-2.5">
                    <form onsubmit="return false;">
                    <button
                        type="submit"
                        role="menuitem"
                        class="group flex w-full items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-left text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-800 active:border-red-100 dark:text-gray-200 dark:hover:bg-gray-700/75 dark:hover:text-white dark:active:border-gray-600"
                    >
                        <svg
                        class="hi-mini hi-lock-closed inline-block size-5 flex-none opacity-25 group-hover:opacity-50"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true"
                        >
                        <path
                            fill-rule="evenodd"
                            d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                            clip-rule="evenodd"
                        />
                        </svg>
                        <span class="grow">Sign out</span>
                    </button>
                    </form>
                </div>
                </div>
            </div>
            <!-- END Dropdown -->
            </div>
            <!-- END User Dropdown -->

            <!-- Toggle Mobile Navigation -->
            <div class="dark lg:hidden">
            <button
                x-on:click="mobileNavOpen = !mobileNavOpen"
                type="button"
                class="inline-flex items-center justify-center space-x-2 rounded-lg border border-red-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-red-800 hover:border-red-300 hover:text-red-900 hover:shadow-sm focus:ring focus:ring-red-300 focus:ring-opacity-25 active:border-red-200 active:shadow-none dark:border-white/20 dark:bg-transparent dark:text-gray-100 dark:hover:border-red-500 dark:hover:border-opacity-75 dark:hover:text-gray-50 dark:focus:ring-red-600 dark:focus:ring-opacity-60 dark:active:border-red-500 dark:active:border-opacity-50"
            >
                <svg
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
                class="hi-solid hi-menu inline-block size-5"
                >
                <path
                    fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"
                ></path>
                </svg>
            </button>
            </div>
            <!-- END Toggle Mobile Navigation -->
        </div>
        <!-- END Right Section -->
        </div>

        <!-- Mobile Navigation -->
        <div x-cloak x-show="mobileNavOpen" class="dark lg:hidden">
        <nav class="flex flex-col space-y-2 border-t py-4 dark:border-white/10">
            <a
            href="javascript:void(0)"
            class="group flex items-center space-x-2 rounded-lg border border-red-50 bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 dark:border-transparent dark:bg-gray-700/75 dark:text-white"
            >
            <span>Dashboard</span>
            </a>
            <a
            href="javascript:void(0)"
            class="group flex items-center space-x-2 rounded-lg border border-transparent px-3 py-2 text-sm font-medium text-gray-800 hover:bg-red-50 hover:text-red-600 active:border-red-100 dark:text-gray-200 dark:hover:bg-white/10 dark:hover:text-white dark:active:border-white/20"
            >
            <span>Data Identitas</span>
            </a>
            <a
            href="javascript:void(0)"
            class="group flex items-center space-x-2 rounded-lg border border-transparent px-3 py-2 text-sm font-medium text-gray-800 hover:bg-red-50 hover:text-red-600 active:border-red-100 dark:text-gray-200 dark:hover:bg-white/10 dark:hover:text-white dark:active:border-white/20"
            >
            <span>Projects</span>
            </a>
            <a
            href="javascript:void(0)"
            class="group flex items-center space-x-2 rounded-lg border border-transparent px-3 py-2 text-sm font-medium text-gray-800 hover:bg-red-50 hover:text-red-600 active:border-red-100 dark:text-gray-200 dark:hover:bg-white/10 dark:hover:text-white dark:active:border-white/20"
            >
            <span>Sales</span>
            </a>
        </nav>
        </div>
        <!-- END Mobile Navigation -->
    </div>
    </header>
    <!-- END Page Header -->

    <!-- Page Content -->
    <main id="page-content" class="flex max-w-full flex-auto flex-col">
    <!-- Page Heading -->
    <div class="dark h-48 bg-red-900 text-gray-100">
        <div class="container mx-auto px-4 lg:px-8 xl:max-w-7xl">
            <div class="flex items-center py-4">
                {{ $heading }}
            </div>
        </div>
    </div>
    <!-- END Page Heading -->

    <!-- Page Section -->
    <div class="container mx-auto -mt-28 p-4 lg:-mt-32 lg:p-8 xl:max-w-7xl">
        <div class="space-y-4">
            <!--

            ADD YOUR MAIN CONTENT BELOW

            -->

            {{ $slot }}

            <!--

            ADD YOUR MAIN CONTENT ABOVE

            -->
        </div>
    </div>
    <!-- END Page Section -->
    </main>
    <!-- END Page Content -->

    <!-- Page Footer -->
    <footer
    id="page-footer"
    class="flex flex-none items-center bg-white dark:bg-gray-800"
    >
    <div
        class="container mx-auto flex flex-col px-4 text-center text-sm md:flex-row md:justify-between md:text-left lg:px-8 xl:max-w-7xl"
    >
        <div class="pb-1 pt-4 md:pb-4">
        <a
            href="https://tailkit.com"
            class="font-medium text-red-600 hover:text-red-400 dark:text-red-400 dark:hover:text-red-300"
            target="_blank"
            >Tailkit</a
        >
        ©
        </div>
        <div class="inline-flex items-center justify-center pb-4 pt-1 md:pt-4">
        <span>Crafted with</span>
        <svg
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
            class="hi-solid hi-heart mx-1 inline-block size-4 text-red-600"
        >
            <path
            fill-rule="evenodd"
            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
            clip-rule="evenodd"
            ></path>
        </svg>
        <span>
            by
            <a
            href="https://pixelcave.com"
            class="font-medium text-red-600 hover:text-red-400 dark:text-red-400 dark:hover:text-red-300"
            target="_blank"
            >pixelcave</a
            ></span
        >
        </div>
    </div>
    </footer>
    <!-- END Page Footer -->
    </div>
    <!-- END Page Container -->
    @filamentScripts
    @vite('resources/js/app.js')
    @livewireScripts
</body>
</html>
