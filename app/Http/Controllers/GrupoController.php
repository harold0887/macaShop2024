<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('customer.grupos.create');
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

        try {
            Grupo::create([
                'escuela' => request('escuela'),
                'grado_grupo' => request('grado_grupo'),
                'cliclo_escolar' => request('ciclo_escolar'),
                'materia' => $request->materia ? $request->materia : null,
                'maestro' => $request->maestro ? $request->maestro : null,
                'color' => request('color'),
                'user_id' => Auth::user()->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);


            return redirect()->route('grupos.index')->with('success', 'El grupo se ha creado con éxito');
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
