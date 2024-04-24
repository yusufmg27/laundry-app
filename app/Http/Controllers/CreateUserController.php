<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use DataTables; // tambahkan ini

class CreateUserController extends Controller
{
    /**
    * Display the registration view.
    */
    public function index(Request $request)
    {
        if(\request()->ajax()){
            $data = User::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" data-id="' . $row->id . '">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                return $actionBtn;
            })                
            ->rawColumns(['action'])
            ->make(true);
        }
        
        return view('pages.users.users');
    }
    
    public function create(): View
    {
        return view('pages.users.users-create');
    }
    
    // Metode untuk menampilkan halaman edit
    public function edit(Request $request)
    {
        $user = User::find($request->id);
        return view('pages.users.users-edit', compact('user'));
    }
    
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        
        return response()->json(['success' => 'User deleted successfully.']);
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
            'role' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        event(new Registered($user));
        
        return redirect(route('users.index', absolute: false));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
        ]);
        
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->save();
        
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}
