<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Layanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('create.service') }}">
                        @csrf

                        <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kolom kiri -->
                            <div class="md:flex md:flex-col">
                                <!-- service_name -->
                                <div>
                                    <x-input-label for="service_name" :value="__('Nama Layanan')" />
                                    <x-text-input id="service_name" class="block mt-1 w-full" type="text" name="service_name" :value="old('service_name')" required autofocus autocomplete="service_name" />
                                    <x-input-error :messages="$errors->get('service_name')" class="mt-2" />
                                </div>
                                <!-- price -->
                                <div class="mt-4"> 
                                    <x-input-label for="price" :value="__('Harga')" />
                                    <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" required autocomplete="price" />
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Kolom kanan -->
                            <div class="md:flex md:flex-col">
                                <!-- units -->
                                <div>
                                    <x-input-label for="units" :value="__('Satuan')" />
                                    <x-text-input id="units" class="block mt-1 w-full" type="text" name="units" :value="old('units')" required autocomplete="units" />
                                    <x-input-error :messages="$errors->get('units')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                
                        <div class="flex items-center justify-end mt-4">
                            {{-- <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a> --}}
                
                            <x-primary-button class="ms-4">
                                {{ __('Buat Layanan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>