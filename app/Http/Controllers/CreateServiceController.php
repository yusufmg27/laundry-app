<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use DataTables; // tambahkan ini

class CreateServiceController extends Controller
{
    /**
    * Display the registration view.
    */
    public function index(Request $request)
    {
        if(\request()->ajax()){
            $data = Service::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" data-id="' . $row->id . '">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                return $actionBtn;
            })                
            ->rawColumns(['action'])
            ->make(true);
        }
        
        return view('pages.service.service');
    }
    
    public function create(): View
    {
        return view('pages.service.service-create');
    }
    
    // Metode untuk menampilkan halaman edit
    public function edit(Request $request)
    {
        $service = Service::find($request->id);
        return view('pages.service.service-edit', compact('service'));
    }
    
    public function destroy(Request $request)
    {
        $service = Service::findOrFail($request->id);
        $service->delete();
        
        return response()->json(['success' => 'Service deleted successfully.']);
    }
    
    /**
    * Handle an incoming registration request.
    *
    * @throws \Illuminate\Validation\ValidationException
    */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'service_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'units' => ['required', 'string'],
        ]);
        
        $user = Service::create([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'units' => $request->units,
        ]);
                
        return redirect(route('service.index', absolute: false));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'service_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'units' => ['required', 'string'],
        ]);
        
        $user = Service::findOrFail($id);
        $user->service_name = $request->service_name;
        $user->price = $request->price;
        $user->units = $request->units;
        $user->save();
        
        return redirect()->route('service.index')->with('success', 'User updated successfully.');
    }
}
