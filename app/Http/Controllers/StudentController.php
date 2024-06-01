<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use App\Models\Condicion_Estudiante;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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


        $request->validate([
            'firstname' => ['required'],
            'lastname' => 'required',
            'genero' => 'required',
            'date' => 'date',
           
        ]);

        try {

            $group = Grupo::findOrFail(request('grupo'));

            if ($group->id == 1) {
                return back()->with('info', 'Este es un grupo de ejemplo, no cuenta con permisos para agregar mas estudiantes.');
            } elseif (request('grupo') == Auth::user()->id) {
                $nuevoEstudiante = Estudiante::create([
                    'nombres' => request('firstname'),
                    'apellidos' => request('lastname'),
                    'fecha_nacimiento' => $request->nacimiento ? $request->nacimiento : null,
                    'genero' => request('genero'),
                    'imagen' => $request->image ? $request->image->store('estudiantes', 'public') : null,
                    'email' => $request->email1 ? $request->email1 : null,
                    'phone' => $request->phone1 ? $request->phone1 : null,
                    'phone2' => $request->phone2 ? $request->phone2 : null,
                    'comentarios' => $request->comentarios ? $request->comentarios : null,
                    'user_id' => Auth::user()->id,
                    'grupo_id' => request('grupo'),
                ]);

                if (request('condiciones') != null) {
                    foreach (request('condiciones') as $item) {
                        Condicion_Estudiante::create([
                            'condicion_id' => $item,
                            'estudiante_id' => $nuevoEstudiante->id,
                        ]);
                    }
                }
                return back()->with('success', 'Registro exitoso');
            } else {
                return back()->with('error', 'No cuenta con permisos para agregar mas estudiantes al grupo - ' . $group->grado_grupo);
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al guardar el registro - ' . $th->getMessage());
        }
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
