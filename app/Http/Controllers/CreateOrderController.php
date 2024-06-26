<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\PaymentMethod;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use DataTables; // tambahkan ini
use Dompdf\Dompdf;
use Dompdf\Options;

class CreateOrderController extends Controller
{
    /**
    * Display the registration view.
    */
    public function index(Request $request)
    {
        if(\request()->ajax()){
            $data = Order::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_id', function($row) {
                    // Mengambil informasi nama pelanggan berdasarkan customer_id pada setiap order
                    $customer = Customer::find($row->customer_id);
                    return $customer ? $customer->name : 'N/A';
                })
                ->addColumn('service_id', function($row) {
                    // Mengambil informasi nama layanan berdasarkan service_id pada setiap order
                    $service = Service::find($row->service_id);
                    return $service ? $service->service_name : 'N/A';
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" data-id="' . $row->id . '">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a> <a href="'.route('order.print', $row->id).'" class="btn btn-secondary btn-sm">Print</a>';
                    return $actionBtn;
                })                
                ->rawColumns(['action'])
                ->make(true);
        }
        $month = date('m'); // Default to current month
        $year = date('Y'); // Default to current year
        
        return view('pages.order.order', compact('month', 'year'));
    }
    
    
    public function create(): View
    {
        $latestOrder = Order::latest()->first();
        $orderCode = $latestOrder ? 'LNDRY-' . (intval(substr($latestOrder->order_code, 6)) + 1) : 'LNDRY-1';
        $services = Service::all();
        $payments = PaymentMethod::all();
        return view('pages.order.order-create', compact('orderCode', 'services', 'payments'));
    }
    
    // Metode untuk menampilkan halaman edit
    public function edit(Request $request)
    {
        $order = Order::find($request->id);
        $services = Service::all();
        $payments = PaymentMethod::all();
        
        // Temukan data pelanggan berdasarkan customer_id order
        $customer = Customer::find($order->customer_id);
        
        return view('pages.order.order-edit', compact('order', 'customer', 'services', 'payments'));
    }
    
    
    public function destroy(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->delete();
        
        return response()->json(['success' => 'order deleted successfully.']);
    }
    
    /**
    * Handle an incoming registration request.
    *
    * @throws \Illuminate\Validation\ValidationException
    */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'order_code' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'numeric', 'min:1', 'max:10'],
            'name' => ['required', 'string', 'max:255'], // Validasi nama pelanggan
            'number' => ['required', 'string', 'max:255'], // Validasi nomor pelanggan
            'address' => ['required', 'string', 'max:255'], // Validasi alamat pelanggan
            'customer_id' => ['nullable', 'numeric', 'min:1'], // Tambahkan 'nullable'
            'service_id' => ['required', 'string'], 
            'payment_method' => ['required', 'string'], 
            'status' => ['required', 'string', 'in:baru,proses,selesai,diambil'], 
            'payment_status' => ['required', 'string', 'in:belum_lunas,lunas'], 
            'payment' => ['required', 'numeric', 'min:0'], 
            'change' => ['required', 'numeric', 'min:0'], 
            'total' => ['required', 'numeric', 'min:0'], 
        ]);
        
        // Temukan atau buat pelanggan berdasarkan nomor telepon yang diberikan
        $customer = Customer::firstOrCreate(
            ['number' => $request->number],
            ['name' => $request->name, 'address' => $request->address]
        );
        
        // Simpan ID pelanggan
        $customerId = $customer->id;
        
        // Simpan order dengan customer_id yang ditemukan atau baru
        $order = Order::create([
            'order_code' => $request->order_code,
            'quantity' => $request->quantity,
            'customer_id' => $customerId,
            'service_id' => $request->service_id,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'payment' => $request->payment,
            'change' => $request->change,
            'total' => $request->total,
        ]);
        
        return redirect(route('order.index', absolute: false));
    }
    
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'order_code' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'numeric', 'min:1', 'max:10'],
            'customer_id' => ['required', 'string', 'max:255'],
            'service_id' => ['required', 'string'], 
            'payment_method' => ['required', 'string'], 
            'status' => ['required', 'string', 'in:baru,proses,selesai,diambil'], 
            'payment_status' => ['required', 'string', 'in:belum_lunas,lunas'],
            'payment' => ['required', 'numeric', 'min:0'], 
            'change' => ['required', 'numeric', 'min:0'],
            'total' => ['required', 'numeric', 'min:0'],
        ]);
        
        $user = Order::findOrFail($id);
        $user->order_code = $request->order_code;
        $user->quantity = $request->quantity;
        $user->customer_id = $request->customer_id;
        $user->service_id = $request->service_id;
        $user->payment_method = $request->payment_method;
        $user->status = $request->status;
        $user->payment_status = $request->payment_status;
        $user->payment = $request->payment;
        $user->change = $request->change;
        $user->total = $request->total;
        $user->save();
        
        
        return redirect()->route('order.index')->with('success', 'User updated successfully.');
        dd($request->all());
    }
    
    public function printReceipt($id)
    {
        $order = Order::findOrFail($id);
    
        // Inisialisasi Dompdf dengan opsi
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
    
        $dompdf = new Dompdf($options);
    
        // Muat HTML dari view dan atur ukuran kertas dan margin
        $dompdf->loadHtml(view('pages.order.receipt', compact('order')));
        $dompdf->setPaper('A7', 'portrait'); // Atur ukuran kertas menjadi A7 (ukuran struk) dan orientasi menjadi potrait
    
        // Render PDF
        $dompdf->render();
    
        // Ambil konten PDF dalam bentuk string
        $pdfContent = $dompdf->output();
    
        // Kembalikan PDF sebagai respons HTTP
        return response($pdfContent)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'inline; filename="receipt_'.$order->order_code.'.pdf"');
    }
    

    // public function exportPdf()
    // {
    //     // Ambil data order bulanan
    //     $orders = Order::whereYear('created_at', '=', date('Y'))
    //                 ->whereMonth('created_at', '=', date('m'))
    //                 ->get();
    
    //     // Mendapatkan nilai bulan dan tahun saat ini
    //     $month = date('F');
    //     $year = date('Y');
    
    //     // Inisialisasi Dompdf dengan opsi
    //     $options = new Options();
    //     $options->set('isHtml5ParserEnabled', true);
    //     $options->set('isPhpEnabled', true);
    
    //     $dompdf = new Dompdf($options);
    
    //     // Muat HTML dari view dan atur ukuran kertas dan margin
    //     $dompdf->loadHtml(view('pages.order.monthly-order-pdf', compact('orders', 'month', 'year')));
    //     $dompdf->setPaper('A4', 'potrait'); // Atur ukuran kertas menjadi A4 (landscape)
    
    //     // Render PDF
    //     $dompdf->render();
    
    //     // Kembalikan PDF kepada pengguna
    //     return $dompdf->stream('laporan_bulan_' . $month . '.pdf');

    //     // // Render PDF
    //     // $dompdf->render();
    
    //     // // Ambil konten PDF dalam bentuk string
    //     // $pdfContent = $dompdf->output();
    
    //     // // Kembalikan PDF sebagai respons HTTP
    //     // return response($pdfContent)
    //     //             ->header('Content-Type', 'application/pdf')
    //     //             ->header('Content-Disposition', 'inline; filename="laporan_bulan_' . $month . '.pdf"');
    // }    

    public function exportPdf(Request $request)
        {
            $year = $request->query('year', date('Y'));
            $month = $request->query('month', date('m'));

            // Ambil data order sesuai dengan tahun dan bulan yang dipilih
            $orders = Order::whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->get();

            // Inisialisasi Dompdf dengan opsi
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);

            $dompdf = new Dompdf($options);

            // Muat HTML dari view dan atur ukuran kertas dan margin
            $dompdf->loadHtml(view('pages.order.monthly-order-pdf', compact('orders', 'month', 'year')));
            $dompdf->setPaper('A4', 'potrait'); // Atur ukuran kertas menjadi A4 (landscape)

            // Render PDF
            $dompdf->render();

            // Kembalikan PDF kepada pengguna
            return $dompdf->stream('laporan_bulan_' . $month . '_' . $year . '.pdf');
        }

    
}
