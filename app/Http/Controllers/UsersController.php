<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }








    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = DB::table('roles')
            ->select('name', 'id')
            ->whereNotIn('name', ['super-admin'])
            ->get();

        $user = User::leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*', 'roles.name as role')
            ->findOrFail($id);



        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {


        // $request->validate([
        //     'roles' => ['required'],
        // ]);

            //dd(request('roles'));




        if (Auth::id() == $user->id) {
            return back()->with('error', 'No pudes modificar tu propia cuenta');
        }
        try {

            $user->syncRoles(request('roles'));

            $user->update([
                'email' => request('email'),
                'facebook' => request('facebook'),
                'whatsapp' => request('whatsapp'),
                'comment' => request('comment'),
            ]);


            return back()->with('success', 'El registro se actualizo de manera correcta');
        } catch (\Throwable $e) {
            return back()->with('error', 'Error al modificar al usuario - ' . $e->getMessage());
        }
    }
}
