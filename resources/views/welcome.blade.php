<style>
    .dataTables_filter {
        display: flex;
        justify-content: flex-end;
    }

        /* Tambahkan gaya untuk menengahkan isi tabel */
        table {
            margin: 0 auto; /* Menengahkan tabel secara horizontal */
            text-align: center; /* Menengahkan isi tabel secara horizontal */
        }
</style>
<x-app-layout>
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
                                    <th>Konsumen</th>
                                    <th>Layanan</th>
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
                deferLoading: 0, // Menunda pemuatan data hingga setelah pencarian pertama kali dilakukan
                ajax: "{{ route('welcome.index') }}",
                columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'order_code', name: 'order_code'},
                {data: 'quantity', name: 'quantity'},
                {data: 'customer_id', name: 'customer_id'},
                {data: 'service_id', name: 'service_id'},
                {data: 'payment_status', name: 'payment_status', render: function (data) {
                    var badgeColor = '';
                    var statusText = capitalizeAndReplace(data);
                    
                    // Menentukan warna badge berdasarkan status pembayaran
                    switch(data) {
                        case 'lunas':
                            badgeColor = 'bg-success';
                            break;
                        case 'belum_lunas':
                            badgeColor = 'bg-danger';
                            break;
                        default:
                            badgeColor = 'bg-primary';
                    }
                    
                    // Mengembalikan badge dengan warna dan teks yang sesuai
                    return '<span class="badge ' + badgeColor + '">' + statusText + '</span>';
                }},
                {data: 'status', name: 'status', render: function (data) {
                    var badgeColor = '';
                    var statusText = capitalizeAndReplace(data);
                    
                    // Menentukan warna badge berdasarkan status laundry
                    switch(data) {
                        case 'baru':
                            badgeColor = 'bg-danger';
                            break;
                        case 'proses':
                            badgeColor = 'bg-warning';
                            break;
                        case 'selesai':
                            badgeColor = 'bg-success';
                            break;
                        case 'diambil':
                            badgeColor = 'bg-secondary';
                            break;
                        default:
                            badgeColor = 'bg-primary';
                    }
                    
                    // Mengembalikan badge dengan warna dan teks yang sesuai
                    return '<span class="badge ' + badgeColor + '">' + statusText + '</span>';
                }},
                ]
            });
            function capitalizeAndReplace(str) {
                // Mengganti tanda _ menjadi spasi dan mengkapitalisasi huruf awal
                return str.replace(/_/g, ' ').replace(/\b\w/g, function (char) {
                    return char.toUpperCase();
                });
            }
        });
        
    </script>
</x-app-layout>