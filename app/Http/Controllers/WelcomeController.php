<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use App\Models\Customer;
use DataTables; // tambahkan ini


class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
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
        
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
