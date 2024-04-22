<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class PackageController extends Controller
{
    public function index()
    {
        return view('admin.package.index');
    }


    public function create()
    {
        return view('admin.package.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'price_with_discount' => 'required',
            'itemMain' => 'required|image',
            'information' => 'required',

        ]);

        if (request('price_with_discount') > request('price')) {
            return back()->with('error', 'El precio con descuento no puede ser mayor al precio sin descuento. ');
        }


        try {
            Package::create([
                'title' => request('title'),
                'price' => request('price'),
                'itemMain' => $request->itemMain ? $request->itemMain->store('portadas', 'public') : null,
                'status' => true,
                'discount_percentage' => 0,
                'price_with_discount' => request('price_with_discount'),
                'model' => 'Package',
                'slug' => Str::slug(request('title'), '-'),
                'information' => request('information'),
            ]);
            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al guardar el paquete - ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.package.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'price_with_discount' => 'required',
            'information' => 'required',

        ]);

        if (request('price_with_discount') > request('price')) {
            return back()->with('error', 'El precio con descuento no puede ser mayor al precio sin descuento. ');
        }




        $package = Package::findOrFail($id);
        $newItemMain = request()->file('itemMain');
        if (isset($newItemMain)) {
            File::delete(storage_path("/app/public/{$package->itemMain}"));
            $itemMain = $newItemMain->store('portadas', 'public');
        } else {
            $itemMain = $package->itemMain;
        }
        try {
            Package::findOrFail($id)->update([
                'title' => request('title'),
                'itemMain' => $itemMain,
                'price' => request('price'),
                'price_with_discount' => request('price_with_discount'),
                'information' => request('information'),
                'slug' => Str::slug(request('title'), '-'),
            ]);
            return back()->with('success', 'El paquete se actualizo de manera correcta');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al actualizar el paquete - ' . $e->getMessage());
        }
    }
}
