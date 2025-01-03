<nav x-data="{ open: false }" class="dark:bg-gray-800 dark:border-gray-700 bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl sm:px-6 lg:px-8 px-4 mx-auto">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="h-9 dark:text-gray-200 block w-auto text-gray-800 fill-current" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="sm:-my-px sm:ms-10 sm:flex hidden space-x-8">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @hasrole('admin')
                        <x-nav-link :href="route('departements.index')" :active="in_array(request()->route()->getName(), [
                            'departements.index',
                            'departements.create',
                            'departements.edit',
                        ])">
                            {{ __('Departement') }}
                        </x-nav-link>

                        <x-nav-link :href="route('karyawan.index')" :active="in_array(request()->route()->getName(), [
                            'karyawan.index',
                            'karyawan.create',
                            'karyawan.edit',
                            'karyawan.reset-password',
                        ])">
                            {{ __('Karyawan') }}
                        </x-nav-link>

                        <x-nav-link :href="route('periode-cutoff.index')" :active="in_array(request()->route()->getName(), [
                            'periode-cutoff.index',
                            'periode-cutoff.create',
                            'periode-cutoff.edit',
                        ])">
                            {{ __('Periode Cutoff') }}
                        </x-nav-link>

                        <x-nav-link :href="route('hari-libur.index')" :active="in_array(request()->route()->getName(), [
                            'hari-libur.index',
                            'hari-libur.create',
                            'hari-libur.edit',
                        ])">
                            {{ __('Hari Libur') }}
                        </x-nav-link>

                        <x-nav-link :href="route('data-kasbon.index')" :active="in_array(request()->route()->getName(), [
                            'data-kasbon.index',
                            'data-kasbon.create',
                            'data-kasbon.edit',
                        ])">
                            {{ __('Kasbon') }}
                        </x-nav-link>
                    @endhasrole

                    <x-nav-link :href="route('data-kehadiran.index')" :active="in_array(request()->route()->getName(), [
                        'data-kehadiran.index',
                        'data-kehadiran.create',
                    ])">
                        {{ __('Kehadiran') }}
                    </x-nav-link>

                    <x-nav-link :href="route('data-lembur.index')" :active="in_array(request()->route()->getName(), ['data-lembur.index', 'data-lembur.create'])">
                        {{ __('Lembur') }}
                    </x-nav-link>

                    <x-nav-link :href="route('data-ijin.index')" :active="in_array(request()->route()->getName(), ['data-ijin.index', 'data-ijin.create'])">
                        {{ __('Ijin') }}
                    </x-nav-link>

                    <x-nav-link :href="route('slip-gaji.index')" :active="in_array(request()->route()->getName(), ['slip-gaji.index'])">
                        {{ __('Slip Gaji') }}
                    </x-nav-link>


                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="sm:flex sm:items-center sm:ms-6 hidden">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 sm:hidden flex items-center">
                <button @click="open = ! open"
                    class="dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @hasrole('admin')
                <x-responsive-nav-link :href="route('departements.index')" :active="in_array(request()->route()->getName(), [
                    'departements.index',
                    'departements.create',
                    'departements.edit',
                ])">
                    {{ __('Departement') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('karyawan.index')" :active="in_array(request()->route()->getName(), [
                    'karyawan.index',
                    'karyawan.create',
                    'karyawan.edit',
                    'karyawan.reset-password',
                ])">
                    {{ __('Karyawan') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('periode-cutoff.index')" :active="in_array(request()->route()->getName(), [
                    'periode-cutoff.index',
                    'periode-cutoff.create',
                    'periode-cutoff.edit',
                ])">
                    {{ __('Periode Cutoff') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('hari-libur.index')" :active="in_array(request()->route()->getName(), [
                    'hari-libur.index',
                    'hari-libur.create',
                    'hari-libur.edit',
                ])">
                    {{ __('Hari Libur') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('data-kasbon.index')" :active="in_array(request()->route()->getName(), [
                    'data-kasbon.index',
                    'data-kasbon.create',
                    'data-kasbon.edit',
                ])">
                    {{ __('Kasbon') }}
                </x-responsive-nav-link>
            @endhasrole

            <x-responsive-nav-link :href="route('data-kehadiran.index')" :active="in_array(request()->route()->getName(), ['data-kehadiran.index', 'data-kehadiran.create'])">
                {{ __('Data Kehadiran') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('data-lembur.index')" :active="in_array(request()->route()->getName(), ['data-lembur.index', 'data-lembur.create'])">
                {{ __('Data Lembur') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('data-ijin.index')" :active="in_array(request()->route()->getName(), ['data-ijin.index', 'data-ijin.create'])">
                {{ __('Data Ijin') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('slip-gaji.index')" :active="in_array(request()->route()->getName(), ['slip-gaji.index'])">
                {{ __('Slip Gaji') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="dark:border-gray-600 pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="dark:text-gray-200 text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
