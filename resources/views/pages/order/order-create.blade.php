<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('create.order') }}">
                        @csrf
                
                        <!-- order_code -->
                        <div>
                            <x-input-label for="order_code" :value="__('Kode Order')" />
                            <x-text-input id="order_code" class="block mt-1 w-full" type="text" name="order_code" :value="$orderCode" required autofocus autocomplete="order_code" readonly />
                            <x-input-error :messages="$errors->get('order_code')" class="mt-2" />
                        </div>

                        <!-- costumer_name -->
                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Nama Konsumen')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- costumer_number -->
                        <div class="mt-4">
                            <x-input-label for="number" :value="__('Nomor Telepon Konsumen')" />
                            <x-text-input id="number" class="block mt-1 w-full" type="text" name="number" :value="old('number')" required autofocus autocomplete="number" />
                            <x-input-error :messages="$errors->get('number')" class="mt-2" />
                        </div>

                        <!-- costumer_address -->
                        <div class="mt-4">
                            <x-input-label for="address" :value="__('Alamat Konsumen')" />
                            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus autocomplete="address" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- service_id -->
                        <div class="mt-4">
                            <x-input-label for="service_id" :value="__('Layanan')" />
                            <select id="service_id" class="block mt-1 w-full rounded-md" name="service_id" required autofocus autocomplete="service_id">
                                <!-- Opsi dropdown -->
                                <option value="">Pilih Layanan</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
                        </div>

                        <!-- quantity -->
                        <div class="mt-4">
                            <x-input-label for="quantity" :value="__('Jumlah')" />
                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="1" required autofocus autocomplete="quantity" />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <!-- total -->
                        <div class="mt-4">
                            <x-input-label for="total" :value="__('Total Harga')" />
                            <x-text-input id="total" class="block mt-1 w-full" type="number" name="total" :value="old('total')" required autofocus autocomplete="total" readonly />
                            <x-input-error :messages="$errors->get('total')" class="mt-2" />
                        </div>

                        <!-- payment_method -->
                        <div class="mt-4">
                            <x-input-label for="payment_method" :value="__('Metode Pembayaran')" />
                            <select id="payment_method" class="block mt-1 w-full rounded-md" name="payment_method" required autofocus autocomplete="payment_method">
                                <!-- Opsi dropdown -->
                                <option value="">Pilih Metode Pembayaran</option>
                                @foreach($payments as $payment)
                                    <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div>

                        <!-- status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" class="block mt-1 w-full rounded-md" name="status" required autofocus autocomplete="status">
                                <!-- Opsi dropdown -->
                                <option value="baru">Baru</option>
                                <option value="proses">Proses</option>
                                <option value="selesai">Selesai</option>
                                <option value="diambil">Diambil</option>
                                <!-- Tambahkan opsi lain sesuai kebutuhan Anda -->
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- payment_status -->
                        <div class="mt-4">
                            <x-input-label for="payment_status" :value="__('Status Pembayaran')" />
                            <select id="payment_status" class="block mt-1 w-full rounded-md" name="payment_status" required autofocus autocomplete="payment_status">
                                <!-- Opsi dropdown -->
                                <option value="belum_lunas">Belum Lunas</option>
                                <option value="lunas">Lunas</option>
                                <!-- Tambahkan opsi lain sesuai kebutuhan Anda -->
                            </select>
                            <x-input-error :messages="$errors->get('payment_status')" class="mt-2" />
                        </div>

                        <!-- payment -->
                        <div class="mt-4">
                            <x-input-label for="payment" :value="__('Uang Bayar')" />
                            <x-text-input id="payment" class="block mt-1 w-full" type="number" name="payment" :value="old('payment')" required autofocus autocomplete="payment" />
                            <x-input-error :messages="$errors->get('payment')" class="mt-2" />
                        </div>

                        <!-- change -->
                        <div class="mt-4">
                            <x-input-label for="change" :value="__('Kembalian')" />
                            <x-text-input id="change" class="block mt-1 w-full" type="number" name="change" :value="old('change')" required autofocus autocomplete="change" readonly/>
                            <x-input-error :messages="$errors->get('change')" class="mt-2" />
                        </div>
                
                        <div class="flex items-center justify-end mt-4">
                            {{-- <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a> --}}
                
                            <x-primary-button class="ms-4">
                                {{ __('Buat Order') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Event listener ketika layanan dipilih
        document.getElementById('service_id').addEventListener('change', function() {
            updateTotalPrice(); // Memanggil fungsi untuk memperbarui total harga setiap kali layanan diubah
        });
    
        // Event listener ketika quantity diubah
        document.getElementById('quantity').addEventListener('input', function() {
            updateTotalPrice(); // Memanggil fungsi untuk memperbarui total harga setiap kali quantity diubah
        });
    
        // Fungsi untuk memperbarui total harga berdasarkan layanan dan quantity yang dipilih
        function updateTotalPrice() {
            var selectedServiceId = document.getElementById('service_id').value;
            var quantity = parseInt(document.getElementById('quantity').value);
            var serviceOptions = <?php echo json_encode($services); ?>;
            var totalPrice = 0;
    
            // Cari layanan yang dipilih dalam daftar layanan
            for(var i = 0; i < serviceOptions.length; i++) {
                if(serviceOptions[i].id == selectedServiceId) {
                    // Hitung total harga berdasarkan harga layanan dan quantity
                    totalPrice = serviceOptions[i].price * quantity;
                    break;
                }
            }
    
            // Isi nilai total harga di field total
            document.getElementById('total').value = totalPrice;
        }
    
        // Event listener ketika nilai pembayaran diubah
        document.getElementById('payment').addEventListener('input', function() {
            // Ambil nilai pembayaran dan total harga
            var payment = parseFloat(this.value);
            var totalPrice = parseFloat(document.getElementById('total').value);
    
            // Hitung kembalian
            var change = payment - totalPrice;
    
            // Isi nilai kembalian di field change
            document.getElementById('change').value = change.toFixed(2); // Menggunakan toFixed untuk membatasi desimal menjadi 2 digit
        });
    </script>
    
    
    
</x-app-layout>