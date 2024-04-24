<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use DataTables; // tambahkan ini

class CreateCustomerController extends Controller
{
    /**
    * Display the registration view.
    */
    public function index(Request $request)
    {
        if(\request()->ajax()){
            $data = Customer::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" data-id="' . $row->id . '">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                return $actionBtn;
            })                
            ->rawColumns(['action'])
            ->make(true);
        }
        
        return view('pages.customer.customer');
    }
    
    public function create(): View
    {
        return view('pages.customer.customer-create');
    }
    
    // Metode untuk menampilkan halaman edit
    public function edit(Request $request)
    {
        $customer = Customer::find($request->id);
        return view('pages.customer.customer-edit', compact('customer'));
    }
    
    public function destroy(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        $customer->delete();
        
        return response()->json(['success' => 'customer deleted successfully.']);
    }
    
    /**
    * Handle an incoming registration request.
    *
    * @throws \Illuminate\Validation\ValidationException
    */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'number' => ['required', 'numeric', 'digits_between:1,16'],
        ]);
        
        $user = Customer::create([
            'name' => $request->name,
            'address' => $request->address,
            'number' => $request->number,
        ]);
                
        return redirect(route('customer.index', absolute: false));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'number' => ['required', 'numeric', 'digits_between:1,16'],
        ]);
        
        $user = Customer::findOrFail($id);
        $user->name = $request->name;
        $user->address = $request->address;
        $user->number = $request->number;
        $user->save();
        
        return redirect()->route('customer.index')->with('success', 'User updated successfully.');
    }
}
