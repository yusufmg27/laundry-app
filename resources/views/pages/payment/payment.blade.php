<style>
    .dataTables_filter {
        display: flex;
        justify-content: flex-end;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Metode Pembayaran') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- {{ __("You're logged in! Users") }} --}}
                    <a href="{{ route('create.payment') }}" class="btn btn-primary text-white font-bold px-4 rounded mt-2">Buat Metode Pembayaran</a>
                </div>
                <div class="table-responsive">
                    <div class="container mt-1 mb-4">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th style="width: 150px" >Action</th>
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
                ajax: "{{ route('payment.index') }}",
                columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action'},
                ]
            });
        });
        
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
                        url: "{{ route('payment.destroy') }}",
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
            window.location.href = "{{ route('payment.edit') }}?id=" + userId;
        });
        
    </script>
</x-app-layout>
