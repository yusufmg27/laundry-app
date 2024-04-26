<style>
    .dataTables_filter {
        display: flex;
        justify-content: flex-end;
    }

    table {
            margin: 0 auto; /* Menengahkan tabel secara horizontal */
            text-align: center; /* Menengahkan isi tabel secara horizontal */
        }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 flex justify-between items-center text-gray-900 dark:text-gray-100">
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'petugas')
                    <a href="{{ route('create.order') }}" class="btn btn-primary text-white font-bold px-4 rounded mt-2">Buat Order</a>
                    @endif
                    <div>
                        <a href="{{ route('order.export.pdf') }}" class="btn btn-danger text-white font-bold px-4 rounded mt-2">Export Laporan</a>
                    </div>
                </div>                
                <div class="table-responsive">
                    <div class="container mt-1 mb-4">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Order</th>
                                    <th>Jumlah</th>
                                    <th>Konsumen</th>
                                    <th>Layanan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Laundry</th>
                                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'petugas')
                                    <th style="width: 200px" >Action</th>
                                    @endif
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
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                ajax: "{{ route('order.index') }}",
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
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'petugas')
                {data: 'action', name: 'action'},
                @endif
                ]
            });
            function capitalizeAndReplace(str) {
                // Mengganti tanda _ menjadi spasi dan mengkapitalisasi huruf awal
                return str.replace(/_/g, ' ').replace(/\b\w/g, function (char) {
                    return char.toUpperCase();
                });
            }
        });
        
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'petugas')
        $(document).on('click', '.delete', function(){
            var userId = $(this).data("id");
            
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda tidak bisa mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Hapus"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi penghapusan
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('order.destroy') }}",
                        data: {
                            "id": userId,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            // Tampilkan SweetAlert2 untuk memberi tahu pengguna bahwa file telah dihapus
                            Swal.fire({
                                title: "Terhapus!",
                                text: "Data telah berhasil dihapus.",
                                icon: "success"
                            });
                            // Muat ulang data tabel setelah penghapusan berhasil
                            $('#myTable').DataTable().ajax.reload();
                        },
                        error: function (data) {
                            console.error('Error:', data);
                        }
                    });
                }
            });
        });
        
        
        $(document).on('click', '.edit', function(){
            var userId = $(this).data("id");
            window.location.href = "{{ route('order.edit') }}?id=" + userId;
        });
        @endif
        
    </script>
</x-app-layout>