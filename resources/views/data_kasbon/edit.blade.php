<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="">
                <a href="{{ route('data-kasbon.index') }}"
                    class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Kembali
                </a>
            </div>

            <h2 class="dark:text-gray-200 text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Data Kasbon') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl sm:px-6 lg:px-8 mx-auto">
            <div
                class="dark:bg-gray-800 dark:border-gray-700 block max-w-sm p-6 mx-auto bg-white border border-gray-200 rounded-lg shadow">
                <form action="{{ route('data-kasbon.update', $data_kasbon) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="karyawan_id" class="dark:text-white block mb-2 text-sm font-medium text-gray-900">
                            Karyawan
                        </label>
                        <select id="karyawan_id" name="karyawan_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            @foreach ($karyawans as $karyawan)
                                <option @selected($karyawan->id == $data_kasbon->karyawan_id) value="{{ $karyawan->id }}">
                                    {{ $karyawan->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('karyawan_id')
                            <p class="text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="tanggal"
                            class="dark:text-white block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('tanggal') border-red-500 @enderror"
                            value="{{ $data_kasbon->tanggal->format('Y-m-d') }}" required />
                        @error('tanggal')
                            <p class="text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="jumlah"
                            class="dark:text-white block mb-2 text-sm font-medium text-gray-900">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('jumlah') border-red-500 @enderror"
                            value="{{ $data_kasbon->jumlah }}" required />
                        @error('jumlah')
                            <p class="text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-end">
                        <button type="submit"
                            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
