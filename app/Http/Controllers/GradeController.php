<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class GradeController extends Controller
{
    public function index()
    {
        $degrees = Grade::get();
        return view('admin.grados.index', compact('degrees'));
    }


    public function create()
    {
        return view('admin.grados.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            Grade::create([
                'name' => request('name')
            ]);
            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {

            return back()->with('error', 'Error al guardar el registro - ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        return view('admin.grados.edit', compact('grade'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            Grade::findOrFail($id)->update([
                'name' => request('name')
            ]);
            return back()->with('success', 'El registro se actualizó de manera correcta');
        } catch (QueryException $e) {

            return back()->with('error', 'Error al actualizar el registro - ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            Grade::destroy($id);
            return back()->with('success', 'El registro se eliminó de manera correcta');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $messageError = 'Uno o mas productos pertenecen a este grado.';
            } else {
                $messageError = $e->getMessage();
            }
            return back()->with('error', 'Error al eliminar el registro - ' . $messageError);
        }
    }
}
