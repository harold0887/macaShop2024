<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('account.account-pase-lista');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gruposUser = Grupo::where('user_id', Auth::id())->get();
        $user = User::findOrFail(Auth::id());



        if ($gruposUser->count() > 0) {
            if ($user->pro) {
                return view('customer.grupos.create');
            } else {
                return back()->with('infoPro', 'La versión gratuita permite registrar solo un grupo, si necesita registrar más grupos. Adquiera la versión PRO');
            }
        } else {
            return view('customer.grupos.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'escuela' => ['required'],
            'grado_grupo' => 'required',
            'ciclo_escolar' => 'required',
            'color' => 'required',
        ]);

        if (isset($request->itemMain)) {
            $request->validate([
                'itemMain' => 'image',
            ]);
        }

        $gruposUser = Grupo::where('user_id', Auth::id())->get();
        $user = User::findOrFail(Auth::id());






        try {

            if ($gruposUser->count() > 0) {
                if ($user->pro) {
                    Grupo::create([
                        'escuela' => request('escuela'),
                        'grado_grupo' => request('grado_grupo'),
                        'ciclo_escolar' => request('ciclo_escolar'),
                        'materia' => $request->materia ? $request->materia : null,
                        'maestro' => $request->maestro ? $request->maestro : null,
                        'color' => request('color'),
                        'user_id' => Auth::user()->id,
                        'itemMain' => $request->itemMain ? $request->itemMain->store('grupos', 'public') : null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    return redirect()->route('grupos.index')->with('success', 'El grupo se ha creado con éxito');
                } else {
                    return back()->with('infoPro', 'La versión gratuita permite registrar solo un grupo, si necesita registrar más grupos. Adquiera la versión PRO');
                }
            } else {
                Grupo::create([
                    'escuela' => request('escuela'),
                    'grado_grupo' => request('grado_grupo'),
                    'ciclo_escolar' => request('ciclo_escolar'),
                    'materia' => $request->materia ? $request->materia : null,
                    'maestro' => $request->maestro ? $request->maestro : null,
                    'color' => request('color'),
                    'user_id' => Auth::user()->id,
                    'itemMain' => $request->itemMain ? $request->itemMain->store('grupos', 'public') : null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                return redirect()->route('grupos.index')->with('success', 'El grupo se ha creado con éxito');
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al guardar el grupo - ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = Grupo::findOrFail($id);
        return view('customer.grupos.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $group = Grupo::findOrFail($id);

        if ($group->user_id == Auth::user()->id || $group->id == 1) {
            return view('customer.grupos.edit', compact('group'));
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = Grupo::findOrFail($id);

        $request->validate([
            'escuela' => ['required'],
            'grado_grupo' => 'required',
            'ciclo_escolar' => 'required',
            'color' => 'required',
        ]);

        if (isset($request->newItemMain)) {
            $request->validate([
                'itemMain' => 'image',
            ]);
        }
        $newItemMain = request()->file('itemMain');
        try {
            if (isset($newItemMain)) {
                File::delete(storage_path("/app/public/{$group->itemMain}"));
                $itemMain = $newItemMain->store('grupos', 'public');
            } else {
                $itemMain = $group->itemMain;
            }

            if ($group->user_id == Auth::user()->id) {
                $group->update([
                    'escuela' => request('escuela'),
                    'grado_grupo' => request('grado_grupo'),
                    'ciclo_escolar' => request('ciclo_escolar'),
                    'materia' => $request->materia ? $request->materia : null,
                    'maestro' => $request->maestro ? $request->maestro : null,
                    'itemMain' => $itemMain,
                    'color' => request('color')
                ]);
                return back()->with('success', 'El grupo se actualizó de manera correcta');
            } else {
                return back()->with('error', 'No cuenta con permisos para editar el grupo - ' . $group->grado_grupo);
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al actualizar el grupo - ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
