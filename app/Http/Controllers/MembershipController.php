<?php

namespace App\Http\Controllers;


use App\Models\Membership;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class MembershipController extends Controller
{
    public function index()
    {
        return view('admin.membership.index');
    }

    public function create()
    {
        return view('admin.membership.create');
    }


    public function store(Request $request)
    {



        $request->validate([
            'title' => 'required',
            'start' => 'required|date|before:expiration',
            'expiration' => 'required|date|after:start',
            'itemMain' => 'required|image',
            'price' => 'required',
            'price_discount' => 'required',
            'information' => 'required',
            'vigencia' => 'required',
        ]);

        $price = number_format((float)request('price'), 2, '.', '');
        //$percentage = request('discount');
        $price_with_discount = number_format((float)request('price_discount'), 2, '.', '');


        if ($price_with_discount > $price) {
            return back()->with('error', 'El precio con descuento no puede ser mayor al precio sin descuento. ');
        }




        try {
            Membership::create([
                'title' => request('title'),
                'price' => $price,
                'price_with_discount' => $price_with_discount,
                'itemMain' => $request->itemMain ? $request->itemMain->store('portadas', 'public') : null,
                'start' => Carbon::parse($request->start)->format('Y-m-d H:i:s'),
                'expiration' => Carbon::parse($request->expiration)->format('Y-m-d H:i:s'),
                'status' => true,
                'slug' => Str::slug(request('title'), '-'),
                'discount_percentage' => 0,
                'information' => request('information'),
                'vigencia' => request('vigencia'),
            ]);
            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {


            return back()->with('error', 'Error al guardar el registro - ' . $e->getMessage());
        }
    }



    public function edit($id)
    {
        $membership = Membership::findOrFail($id);
        return view('admin.membership.edit', compact('membership'));
    }

    public function show($id)
    {
        $membership = Membership::withCount(['sales' => function ($query) {
            $query->whereHas('order', function ($query) {
                $query
                    ->where('status', 'approved')
                    ->whereNotIn('customer_id', [1, 5, 8218]);
                // ->where('payment_type', '!=', 'externo');
            });
        }])->findOrFail($id);




        return view('admin.membership.show', compact('membership'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'start' => 'required|date|before:expiration',
            'expiration' => 'required|date|after:start',
            'price' => 'required',
            'discount' => 'required',
            'information' => 'required',
            'vigencia' => 'required',
        ]);

        if (request('discount') > request('price')) {
            return back()->with('error', 'El precio con descuento no puede ser mayor al precio sin descuento. ');
        }

        $membership = Membership::findOrFail($id);
        try {
            $newItemMain = request()->file('itemMain');

            if (isset($newItemMain)) {
                File::delete(storage_path("/app/public/{$membership->itemMain}"));
                $itemMain = request()->file('itemMain')->store('portadas', 'public');
            } else {
                $itemMain = $membership->itemMain;
            }




            Membership::findOrFail($id)->update([
                'title' => request('title'),
                'price' => request('price'),
                'price_with_discount' => request('discount'),
                'itemMain' => $itemMain,
                'start' => request('start'),
                'expiration' => request('expiration'),
                'status' => true,
                'slug' => Str::slug(request('title'), '-'),
                'information' => request('information'),
                'vigencia' => request('vigencia'),
            ]);
            return back()->with('success', 'El registro se actualizó de manera correcta');
        } catch (\Throwable $e) {
            return back()->with('error', 'Error al actualizar el registro - ' . $e->getMessage());
        }
    }
}
