<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf
                    <div class="space-y-6">
                        <x-input-label for="nama_role" :value="__('Nama_Role')" />
                        <x-text-input id="nama_role" name="nama_role" type="text" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nama_role')" />
                    </div>
                    <div class="space-y-6">
                        <x-input-label for="permissions" :value="__('Permissions')" />
                        <x-checkbox-list id="permissions" name="permissions" :options="$permissions" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('permissions')" />
                    </div>
                    <x-button class="block w-full">
                        {{ __('Create Role') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
