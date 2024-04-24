<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Konsumen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('customer.update', $customer->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kolom kiri -->
                            <div class="md:flex md:flex-col">
                                <!-- customer_name -->
                                <div>
                                    <x-input-label for="name" :value="__('Nama Konsumen')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$customer->name" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- address -->
                                <div class="mt-4">
                                    <x-input-label for="address" :value="__('Alamat')" />
                                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="$customer->address" required autofocus autocomplete="address" />
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Kolom kanan -->
                            <div class="md:flex md:flex-col">
                                <!-- number -->
                                <div>
                                    <x-input-label for="number" :value="__('Nomor Telepon')" />
                                    <x-text-input id="number" class="block mt-1 w-full" type="number" name="number" :value="$customer->number" required autocomplete="number" />
                                    <x-input-error :messages="$errors->get('number')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Edit Konsumen') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
