<x-app-layout>
    <x-slot name="header">
        <h2 class="dark:text-gray-200 text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-full mx-auto">
        <div class="md:grid-cols-2 grid grid-cols-1 gap-3 mb-5">

            <div x-data="{ showFull: false }">
                <a href="#" @click.prevent="showFull = !showFull"
                    class="hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 block p-6 bg-white border border-gray-200 rounded-lg shadow">

                    <div class="flex justify-between gap-3">
                        <h5 class="dark:text-white mb-2 text-2xl font-bold tracking-tight text-gray-900">
                            <span x-show="showFull" id="summary_gaji">Rp.{{ $thp_show }}</span>
                            <span x-show="!showFull" class="font-bold">Rp.{{ $thp_hide }}</span>
                            <p class="dark:text-gray-400 mt-2 text-sm font-normal text-gray-700">
                                Summary Take Home Pay<br />Bulan Aktif
                            </p>
                        </h5>

                        <button type="button"
                            class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            <i class="fas fa-eye"
                                :class="{ 'fas fa-eye-slash': showFull, 'fas fa-eye': !showFull }"></i>
                        </button>
                    </div>
                </a>
            </div>

            <div x-data="{ showFull: false }">
                <a href="#" @click.prevent="showFull = !showFull"
                    class="hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 block p-6 bg-white border border-gray-200 rounded-lg shadow">

                    <div class="flex justify-between gap-3">
                        <h5 class="dark:text-white mb-2 text-2xl font-bold tracking-tight text-gray-900">
                            <span x-show="showFull" id="summary_lembur">Rp.{{ $lembur_show }}</span>
                            <span x-show="!showFull" class="font-bold">Rp.{{ $lembur_hide }}</span>
                            <p class="dark:text-gray-400 mt-2 text-sm font-normal text-gray-700">
                                Lembur<br />Bulan Aktif
                            </p>
                        </h5>

                        <button type="button"
                            class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            <i class="fas fa-eye"
                                :class="{ 'fas fa-eye-slash': showFull, 'fas fa-eye': !showFull }"></i>
                        </button>
                    </div>
                </a>
            </div>


        </div>

        <div class="md:grid-cols-2 grid grid-cols-1 gap-3">

            <div x-data="{ showFull: false }">
                <a href="#" @click.prevent="showFull = !showFull"
                    class="hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 block p-6 bg-white border border-gray-200 rounded-lg shadow">

                    <div class="flex justify-between gap-3">
                        <h5 class="dark:text-white mb-2 text-2xl font-bold tracking-tight text-gray-900">
                            <span x-show="showFull" class="font-bold">Rp.{{ $gaji_kehadiran_show }}</span>
                            <span x-show="!showFull" class="font-bold">Rp.{{ $gaji_kehadiran_hide }}</span>
                            <p class="dark:text-gray-400 mt-2 text-sm font-normal text-gray-700">
                                Gaji Kehadiran<br />Bulan Aktif
                            </p>
                        </h5>

                        <button type="button"
                            class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            <i class="fas fa-eye"
                                :class="{ 'fas fa-eye-slash': showFull, 'fas fa-eye': !showFull }"></i>
                        </button>
                    </div>
                </a>
            </div>

            <div x-data="{ showFull: false }">
                <a href="#" @click.prevent="showFull = !showFull"
                    class="hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 block p-6 bg-white border border-gray-200 rounded-lg shadow">

                    <div class="flex justify-between gap-3">
                        <h5 class="dark:text-white mb-2 text-2xl font-bold tracking-tight text-gray-900">
                            <span x-show="showFull"
                                id="potongan_keterlambatan">Rp.{{ $potongan_keterlambatan_show }}</span>
                            <span x-show="!showFull" class="font-bold">Rp.{{ $potongan_keterlambatan_hide }}</span>
                            <p class="dark:text-gray-400 mt-2 text-sm font-normal text-gray-700">
                                Potongan Keterlambatan<br />Bulan Aktif
                            </p>
                        </h5>

                        <button type="button"
                            class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            <i class="fas fa-eye"
                                :class="{ 'fas fa-eye-slash': showFull, 'fas fa-eye': !showFull }"></i>
                        </button>
                    </div>
                </a>
            </div>

            <div x-data="{ showFull: false }">
                <a href="#" @click.prevent="showFull = !showFull"
                    class="hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 block p-6 bg-white border border-gray-200 rounded-lg shadow">

                    <div class="flex justify-between gap-3">
                        <h5 class="dark:text-white mb-2 text-2xl font-bold tracking-tight text-gray-900">
                            <span x-show="showFull" id="potongan_ijin">Rp.{{ $potongan_ijin_show }}</span>
                            <span x-show="!showFull" class="font-bold">Rp.{{ $potongan_ijin_hide }}</span>
                            <p class="dark:text-gray-400 mt-2 text-sm font-normal text-gray-700">
                                Potongan Ijin<br />Bulan Aktif
                            </p>
                        </h5>

                        <button type="button"
                            class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            <i class="fas fa-eye"
                                :class="{ 'fas fa-eye-slash': showFull, 'fas fa-eye': !showFull }"></i>
                        </button>
                    </div>
                </a>
            </div>

            <div x-data="{ showFull: false }">
                <a href="#" @click.prevent="showFull = !showFull"
                    class="hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 block p-6 bg-white border border-gray-200 rounded-lg shadow">

                    <div class="flex justify-between gap-3">
                        <h5 class="dark:text-white mb-2 text-2xl font-bold tracking-tight text-gray-900">
                            <span x-show="showFull" id="potongan_kasbon">Rp.{{ $potongan_kasbon_show }}</span>
                            <span x-show="!showFull" class="font-bold">Rp.{{ $potongan_kasbon_hide }}</span>
                            <p class="dark:text-gray-400 mt-2 text-sm font-normal text-gray-700">
                                Potongan Kasbon<br />Bulan Aktif
                            </p>
                        </h5>

                        <button type="button"
                            class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            <i class="fas fa-eye"
                                :class="{ 'fas fa-eye-slash': showFull, 'fas fa-eye': !showFull }"></i>
                        </button>
                    </div>
                </a>
            </div>


        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    @endpush
</x-app-layout>
