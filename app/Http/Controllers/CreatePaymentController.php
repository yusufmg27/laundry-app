<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use DataTables; // tambahkan ini

class CreatePaymentController extends Controller
{
    /**
    * Display the registration view.
    */
    public function index(Request $request)
    {
        if(\request()->ajax()){
            $data = PaymentMethod::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" data-id="' . $row->id . '">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                return $actionBtn;
            })                
            ->rawColumns(['action'])
            ->make(true);
        }
        
        return view('pages.payment.payment');
    }
    
    public function create(): View
    {
        return view('pages.payment.payment-create');
    }
    
    // Metode untuk menampilkan halaman edit
    public function edit(Request $request)
    {
        $payment = PaymentMethod::find($request->id);
        return view('pages.payment.payment-edit', compact('payment'));
    }
    
    public function destroy(Request $request)
    {
        $payment = PaymentMethod::findOrFail($request->id);
        $payment->delete();
        
        return response()->json(['success' => 'payment deleted successfully.']);
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
        ]);
        
        $user = PaymentMethod::create([
            'name' => $request->name,
        ]);
                
        return redirect(route('payment.index', absolute: false));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        
        $user = PaymentMethod::findOrFail($id);
        $user->name = $request->name;
        $user->save();
        
        return redirect()->route('payment.index')->with('success', 'User updated successfully.');
    }
}
