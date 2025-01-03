<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="dark:text-gray-200 text-xl font-semibold leading-tight text-gray-800">
                {{ __('Data Slip Gaji') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl sm:px-6 lg:px-8 mx-auto">

            @if ($errors->any())
                <div class="dark:bg-red-700 dark:text-red-100 px-6 py-4 mb-4 text-red-700 bg-red-100 rounded-md">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="dark:text-red-100">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="dark:bg-gray-800 sm:rounded-lg overflow-hidden bg-white shadow-sm">
                <div class="dark:text-gray-100 p-6 text-gray-900">

                    <div class="sm:rounded-lg relative overflow-x-auto shadow-md">
                        <table id="tables" class="dark:text-gray-400 w-full text-sm text-left text-gray-500">
                            <thead
                                class="bg-gray-50 dark:bg-gray-700 dark:text-gray-400 text-xs text-gray-700 uppercase">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Karyawan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Periode
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Hadir
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Absen
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Ijin
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Terlambat
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Lembur
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        <i class="fas fa-cog"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($slip_gajis->isEmpty())
                                    <tr
                                        class="dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 bg-white border-b">
                                        <th class="whitespace-nowrap dark:text-white px-6 py-4 font-medium text-center text-gray-900"
                                            colspan="8">
                                            Data tidak ditemukan
                                        </th>
                                    </tr>
                                @endif
                                @foreach ($slip_gajis as $slip_gaji)
                                    <tr
                                        class="dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 bg-white border-b">
                                        <td class="px-6 py-4">
                                            {{ $slip_gaji->karyawan->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $slip_gaji->periode_cutoff->lembur_start->format('d M Y') }} s/d
                                            {{ $slip_gaji->periode_cutoff->lembur_end->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $slip_gaji->total_hari_kerja }} Hari
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $slip_gaji->total_hari_tidak_kerja }} Hari
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $slip_gaji->total_hari_ijin }} Hari
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $slip_gaji->jam_terlambat }} Jam
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $slip_gaji->total_jam_lembur }} Jam
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('slip-gaji.download', $slip_gaji) }}"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                target="_blank"><i class="fa-solid fa-file-arrow-down"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $slip_gajis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script></script>
    @endpush
</x-app-layout>
