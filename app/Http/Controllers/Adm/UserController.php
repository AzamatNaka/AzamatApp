<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::with('role')->get();
        return view('adm.users', ['users' => $users, 'roles' => Role::all()]);
    }

    public function ban(User $user){
        $user->update([
            'is_active' => false,
        ]);
        return back();
    }

    public function unban(User $user){
        $user->update([
            'is_active' => true,
        ]);
        return back();
    }

    public function update(User $user, Request $request){

        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $user->update($validated);
        return back()->with('message', 'User role updated successfully!');
    }

//    version for search
//    public function index(Request $request){
//        $users = null;
//        if ($request->search){
//            $users = User::where('name', 'LIKE', '%'.$request->search.'%')
//            ->orWhere('email', 'LIKE', '%'.$request->search.'%')
//            ->with('role')->get();
//        }
//        else{
//            $users = User::with('role')->get();
//        }
//        return view('adm.users', ['users' => $users]);
//    }

}
