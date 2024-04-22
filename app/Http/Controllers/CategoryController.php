<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name')->paginate(100);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            Category::create([
                'name' => request('name')
            ]);
            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {

            return back()->with('error', 'Error al guardar el registro - ' . $e->getMessage());
        }
    }



    public function edit($id)
    {
        return view('admin.categories.edit', [
            'category' => Category::findOrFail($id)
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            Category::findOrFail($id)->update([
                'name' => request('name')
            ]);
            return back()->with('success', 'El registro se actualizó de manera correcta');
        } catch (\Throwable $e) {

            return back()->with('error', 'Error al guardar el registro - ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            Category::destroy($id);
            return back()->with('success', 'El registro se eliminó de manera correcta');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $messageError = 'Uno o mas productos pertenecen a esta categoria.';
            } else {
                $messageError = $e->getMessage();
            }
            return back()->with('error', 'Error al eliminar el registro - ' . $messageError);
        }
    }
}
