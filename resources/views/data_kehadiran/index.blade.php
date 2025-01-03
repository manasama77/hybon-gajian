<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="dark:text-gray-200 text-xl font-semibold leading-tight text-gray-800">
                {{ __('Data Kehadiran') }}
            </h2>

            <div class="">
                <a href="{{ route('data-kehadiran.create') }}"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Tambah Data Presensi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl sm:px-6 lg:px-8 mx-auto">
            @if (session('success'))
                <div class="relative px-4 py-3 mt-4 text-green-700 bg-green-100 border border-green-400 rounded"
                    role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="sm:inline block">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="relative px-4 py-3 mt-4 text-red-700 bg-red-100 border border-red-400 rounded"
                    role="alert">
                    <strong class="font-bold">Error!</strong>
                    <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
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
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Clock In
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Clock Out
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Terlambat
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data_kehadirans->isEmpty())
                                    <tr
                                        class="dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 bg-white border-b">
                                        <th class="whitespace-nowrap dark:text-white px-6 py-4 font-medium text-center text-gray-900"
                                            colspan="6">
                                            Data tidak ditemukan
                                        </th>
                                    </tr>
                                @endif
                                @foreach ($data_kehadirans as $data_kehadiran)
                                    <tr
                                        class="dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 bg-white border-b">
                                        <td class="px-6 py-4">
                                            {{ $data_kehadiran->karyawan->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data_kehadiran->periode_cutoff->kehadiran_start->format('d M Y') }} s/d
                                            {{ $data_kehadiran->periode_cutoff->kehadiran_end->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data_kehadiran->tanggal->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data_kehadiran->clock_in }}
                                            @if ($data_kehadiran->foto_in)
                                                <a href="{{ route('data-kehadiran.show', ['path' => $data_kehadiran->foto_in]) }}"
                                                    class="focus:outline-none hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 me-2 dark:focus:ring-yellow-900 px-3 py-2 mb-2 ml-2 text-sm font-medium text-white bg-yellow-500 rounded-lg"
                                                    target="_blank">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data_kehadiran->clock_out }}
                                            @if ($data_kehadiran->foto_out)
                                                <a href="{{ route('data-kehadiran.show', ['path' => $data_kehadiran->foto_out]) }}"
                                                    class="focus:outline-none hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 me-2 dark:focus:ring-yellow-900 px-3 py-2 mb-2 ml-2 text-sm font-medium text-white bg-yellow-500 rounded-lg"
                                                    target="_blank">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data_kehadiran->menit_terlambat }} Menit
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $data_kehadirans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function askDelete(formId) {
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
