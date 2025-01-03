<x-app-layout>
    <x-slot name="header">
        <h2 class="dark:text-gray-200 text-xl font-semibold leading-tight text-gray-800">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl sm:px-6 lg:px-8 mx-auto space-y-6">
            <div class="sm:p-8 dark:bg-gray-800 sm:rounded-lg p-4 bg-white shadow">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="sm:p-8 dark:bg-gray-800 sm:rounded-lg p-4 bg-white shadow">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <div class="sm:p-8 dark:bg-gray-800 sm:rounded-lg p-4 bg-white shadow">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
