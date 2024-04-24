<style>
    .dataTables_filter {
        display: flex;
        justify-content: flex-end;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <b><i>{{ __('LAUNDRY SMKN 1 CIAMIS') }}</i></b>
            </h2>
            <a href="{{ route('login') }}" title="Login">
                <i class="fas fa-sign-in-alt fa-lg text-secondary"></i> <!-- Font Awesome icon for login -->
            </a>
        </div>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 ">
                    <h1 style="font-size: 1.25rem;">Orderan anda sedang dalam proses!</h1>
                </div>                
                <div class="table-responsive">
                    <div class="container mt-1 mb-4">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Code</th>
                                    <th>Jumlah</th>
                                    <th>Id Konsumen</th>
                                    <th>Id Layanan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Laundry</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function () {
            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('welcome.index') }}",
                columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'order_code', name: 'order_code'},
                {data: 'quantity', name: 'quantity'},
                {data: 'customer_id', name: 'customer_id'},
                {data: 'service_id', name: 'service_id'},
                {data: 'payment_status', name: 'payment_status'},
                {data: 'status', name: 'status'},
                ]
            });
        });
        
    </script>
</x-app-layout>