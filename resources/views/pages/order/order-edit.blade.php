<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('order.update', $order->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kolom kiri -->
                            <div class="md:flex md:flex-col">
                                <!-- order_code -->
                                <div>
                                    <x-input-label for="order_code" :value="__('Kode Order')" />
                                    <x-text-input id="order_code" class="block mt-1 w-full" type="text" name="order_code" :value="$order->order_code" required autofocus autocomplete="order_code" readonly />
                                    <x-input-error :messages="$errors->get('order_code')" class="mt-2" />
                                </div>

                                <!-- customer_id -->
                                <div class="mt-4">
                                    <x-input-label for="customer_id" :value="__('Nama Konsumen')" />
                                    <x-text-input id="customer_id" class="block mt-1 w-full" type="hidden" name="customer_id" :value="$order->customer->id" required autofocus autocomplete="customer_id" />
                                    <x-text-input class="block mt-1 w-full" type="text" :value="$order->customer->name" required autofocus readonly />
                                    <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                                </div>

                                <!-- service_id -->
                                <div class="mt-4">
                                    <x-input-label for="service_id" :value="__('Layanan')" />
                                    <select id="service_id" class="block mt-1 w-full rounded-md" name="service_id" required autofocus autocomplete="service_id">
                                        
                                    @if(auth()->user()->role == 'petugas')
                                            @foreach($services as $service)
                                            @if($order->service_id == $service->id)
                                                <option value="{{ $service->id }}" selected>{{ $service->service_name }}</option>
                                            @endif
                                            @endforeach
                                    @else
                                            @foreach($services as $service)
                                            <option value="{{ $service->id }}" @if($order->service_id == $service->id) selected @endif>{{ $service->service_name }}</option>
                                            @endforeach                                    
                                    @endif
                                    </select>
                                    <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
                                </div>

                                <!-- quantity -->
                                <div class="mt-4">
                                    <x-input-label for="quantity" :value="__('Jumlah')" />
                                        @if(auth()->user()->role == 'petugas')
                                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="$order->quantity" required autofocus autocomplete="quantity" readonly />
                                        @else
                                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="$order->quantity" required autofocus autocomplete="quantity" />
                                        @endif
                                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                </div>

                                <!-- payment_method -->
                                <div class="mt-4">
                                    <x-input-label for="payment_method" :value="__('Metode Pembayaran')" />
                                    <select id="payment_method" class="block mt-1 w-full rounded-md" name="payment_method" required autofocus autocomplete="payment_method">
                                        <!-- Opsi dropdown -->
                                        @foreach($payments as $payment)
                                            <option value="{{ $payment->id }}" @if($order->payment_method == $payment->id) selected @endif>{{ $payment->name }}</option>
                                        @endforeach
                                        <!-- Tambahkan opsi lain sesuai kebutuhan Anda -->
                                    </select>
                                    <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                                </div>
                            </div>
        
                            <!-- Kolom kanan -->
                            <div class="md:flex md:flex-col">

                                <!-- status -->
                                <div>
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select id="status" class="block mt-1 w-full rounded-md" name="status" required autofocus autocomplete="status">
                                    <!-- Opsi dropdown -->
                                    @if(auth()->user()->role == 'petugas')
                                    @if($order->status != 'diambil')
                                    <option value="baru" @if($order->status == 'baru') selected @endif>Baru</option>
                                    <option value="proses" @if($order->status == 'proses') selected @endif>Proses</option>
                                    <option value="selesai" @if($order->status == 'selesai') selected @endif>Selesai</option>
                                    @endif
                                    <option value="diambil" @if($order->status == 'diambil') selected @endif>Diambil</option>
                                    @else
                                    <option value="baru" @if($order->status == 'baru') selected @endif>Baru</option>
                                    <option value="proses" @if($order->status == 'proses') selected @endif>Proses</option>
                                    <option value="selesai" @if($order->status == 'selesai') selected @endif>Selesai</option>
                                    <option value="diambil" @if($order->status == 'diambil') selected @endif>Diambil</option>
                                    @endif
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>

                                <!-- payment_status -->
                                <div class="mt-4">
                                    <x-input-label for="payment_status" :value="__('Status Pembayaran')" />
                                    <select id="payment_status" class="block mt-1 w-full rounded-md" name="payment_status" required autofocus autocomplete="payment_status">
                                        <!-- Opsi dropdown -->
                                        @if($order->payment_status == 'belum_lunas')
                                            <option value="belum_lunas" selected>Belum Lunas</option>
                                        @elseif($order->payment_status == 'lunas')
                                            <option value="lunas" selected>Lunas</option>
                                        @endif
                                    </select>
                                    <x-input-error :messages="$errors->get('payment_status')" class="mt-2" />
                                </div>

                                <!-- total -->
                                <div class="mt-4">
                                    <x-input-label for="total" :value="__('Total Harga')" />
                                    <x-text-input id="total" class="block mt-1 w-full" type="number" name="total" :value="$order->total" required autofocus autocomplete="total" readonly />
                                    <x-input-error :messages="$errors->get('total')" class="mt-2" />
                                </div>

                                <!-- payment -->
                                <div class="mt-4">
                                    <x-input-label for="payment" :value="__('Uang Bayar')" />
                                    <x-text-input id="payment" class="block mt-1 w-full" type="number" name="payment" :value="$order->payment" required autofocus autocomplete="payment" />
                                    <x-input-error :messages="$errors->get('payment')" class="mt-2" />
                                </div>

                                <!-- change -->
                                <div class="mt-4">
                                    <x-input-label for="change" :value="__('Kembalian')" />
                                    <x-text-input id="change" class="block mt-1 w-full" type="number" name="change" :value="$order->change" required autofocus autocomplete="change" readonly />
                                    <x-input-error :messages="$errors->get('change')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                
                        <div class="flex items-center justify-end mt-4">
                            {{-- <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a> --}}
                
                            <x-primary-button class="ms-4">
                                {{ __('Update Order') }}
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
            updateQuantityLabel(); // Memanggil fungsi untuk memperbarui label quantity dengan unit yang sesuai
            updatePaymentStatusOption(); // Memanggil fungsi untuk memperbarui opsi pembayaran
        });
    
        // Event listener ketika quantity diubah
        document.getElementById('quantity').addEventListener('input', function() {
            updateTotalPrice(); // Memanggil fungsi untuk memperbarui total harga setiap kali quantity diubah
        });
    
        // Event listener ketika nilai pembayaran diubah
        document.getElementById('payment').addEventListener('input', function() {
            updatePaymentStatusOption(); // Memanggil fungsi untuk memperbarui opsi pembayaran
            updateChange(); // Memanggil fungsi untuk memperbarui kembalian
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
    
        // Fungsi untuk memperbarui label quantity dengan unit yang sesuai dari layanan yang dipilih
        function updateQuantityLabel() {
            var selectedServiceId = document.getElementById('service_id').value;
            var serviceOptions = <?php echo json_encode($services); ?>;
            var quantityLabel = "";
    
            // Cari layanan yang dipilih dalam daftar layanan
            for(var i = 0; i < serviceOptions.length; i++) {
                if(serviceOptions[i].id == selectedServiceId) {
                    // Dapatkan unit layanan yang dipilih
                    quantityLabel = "Jumlah (" + serviceOptions[i].units + ")";
                    break;
                }
            }
    
            // Isi teks label quantity dengan unit yang sesuai
            document.querySelector('[for="quantity"]').innerText = quantityLabel;
        }
    
        // Fungsi untuk memperbarui opsi pembayaran berdasarkan kondisi
        function updatePaymentStatusOption() {
            var selectedServiceId = document.getElementById('service_id').value;
            var paymentInput = document.getElementById('payment').value;
            var totalPrice = parseFloat(document.getElementById('total').value);
    
            // Jika belum memilih layanan atau belum mengisi pembayaran, hilangkan opsi "Lunas"
            if (!selectedServiceId || !paymentInput || parseFloat(paymentInput) < totalPrice) {
                document.getElementById('payment_status').innerHTML = '<option value="belum_lunas">Belum Lunas</option>';
            } else {
                // Jika uang bayar mencukupi total harga, tampilkan opsi "Lunas"
                document.getElementById('payment_status').innerHTML = '<option value="lunas">Lunas</option>';
            }
        }
    
        // Fungsi untuk memperbarui kembalian
        function updateChange() {
            var payment = parseFloat(document.getElementById('payment').value);
            var totalPrice = parseFloat(document.getElementById('total').value);
            var change = payment - totalPrice;
    
            // Jika kembalian negatif, atur kembali menjadi 0
            if (change < 0) {
                change = 0;
            }
    
            // Isi nilai kembalian di field change
            document.getElementById('change').value = change.toFixed(2); // Menggunakan toFixed untuk membatasi desimal menjadi 2 digit
        }
    </script>
</x-app-layout>
