<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grupo;
use App\Models\Condicion;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use App\Models\Condicion_Estudiante;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd($request->all());

        $request->validate([
            'firstname' => ['required'],
            'lastname' => 'required',
            'genero' => 'required',
            'nacimiento' => 'required|date',
        ]);


        $group = Grupo::findOrFail(request('grupo'));
        $alumnos = Estudiante::where('grupo_id', $group->id)->get();


        try {
            if ($group->user_id == Auth::user()->id) {
                if (Auth::user()->pro || $alumnos->count() < 25) {
                    $nuevoEstudiante = Estudiante::create([
                        'nombres' => request('firstname'),
                        'apellidos' => request('lastname'),
                        'fecha_nacimiento' => request('nacimiento'),
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
                    return redirect()->route('grupos.index')->with('infoPro', 'La versión gratuita permite registrar máximo 25 alumnos, si necesita registrar más alumnos. Adquiera la versión PRO');
                    //return back()->with('info', 'La versión gratuita permite registrar máximo 25 alumnos, si necesita registrar más alumnos.');
                }
            } else {
                return back()->with('error', 'No cuenta con permisos para agregar estudiantes al grupo - ' . $group->id);
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
