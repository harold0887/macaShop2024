<?php

namespace App\Livewire;

use ErrorException;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use App\Mail\EnvioMaterial;
use App\Models\Order_Details;
use App\Http\Helpers\AddLicense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;

class AccountProducts extends Component
{
    public $order;
    public $product;
    public $products;
    

    public function render()
    {
        $this->products = Order_Details::whereHas('order', function ($query) {
            $query->where('orders.customer_id', Auth::user()->id)
                ->where('orders.status', 'approved');
        })->where('order_details.product_id', '!=', null)
            ->get();

        return view('livewire.account-products')
            ->extends('layouts.app', [
                'title' => 'Mis productos',
                'navbarClass' => 'navbar-transparent',
                'activePage' => 'products',
                'menuParent' => 'orders',
            ])
            ->section('content');;
    }

    public function finalDownload($id, $order)
    {
        $this->product = Product::findOrFail($id);
        $this->order = Order::findOrFail($order);



        $orderId = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('order_details.product_id', $id)
            ->where('orders.status', 'approved')
            ->get()
            ->count();

        try {
            if ($orderId > 0) {

                //validar si es un PDF y que tenga folio activado
                if ($this->product->format == 'pdf' && $this->product->folio == 1) {

                    //agregar licencia
                    $addLicense = new AddLicense($id, $this->order->id);
                    if ($addLicense->setLicense()) {
                        $file = "pdf/newpdf.pdf";
                        return response()->download($file, $this->product->title . ".pdf");
                    }
                } else {
                    $file = "public/storage/" . $this->product->document;
                    return response()->download($file, $this->product->title . "." . $this->product->format);
                }
            } else {
                $this->dispatch('error', message: 'No tiene permiso para descargar: ' . $this->product->title);
            }
        } catch (QueryException $e) {
            $this->dispatch('error', message: 'No se pudo descargar el archivo - ' . $this->product->title . ' - ' . $e->getMessage());
        } catch (FileNotFoundException $e) {
            $this->dispatch('error', message: 'El archivo no existe - ' . $this->product->title . ' - ' . $e->getMessage());
        } catch (CrossReferenceException $e) {
            $this->dispatch('error', message: 'No se pudo convertir el archivo - ' . $this->product->title . ' - ' . $e->getMessage());
        } catch (ErrorException  $e) {
            $this->dispatch('error', message: 'No se pudo descargar el archivo    - ' . $this->product->title . ' - ' . $e->getMessage());
        } finally {
            $this->dispatch('alertDownload', message: "<span class='text-sm'><b>Importante !</b> - Si tiene problemas con la descarga, se recomienda descargar desde una computadora.</span>");
        }
    }



    public function sendEmail($id, $order)
    {
        $this->product = Product::findOrFail($id);
        $this->order = Order::findOrFail($order);



        $orderId = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.customer_id', Auth::user()->id)
            ->where('order_details.product_id', $id)
            ->where('orders.status', 'approved')
            ->get()
            ->count();
        try {
            if ($orderId > 0) {

                //validar si es un PDF y que tenga folio activado
                if ($this->product->format == 'pdf' && $this->product->folio == 1) {

                    //agregar licencia
                    $addLicense = new AddLicense($id, $this->order->id);
                    if ($addLicense->setLicense()) {

                        set_time_limit(0);
                        $correo = new EnvioMaterial($this->product);
                        Mail::to(Auth::user()->email)->send($correo);
                        $this->dispatch(
                            'sendSuccessHtml',
                            product: $this->product->title,
                            note: 'Se han enviado correctamente a: ',
                            email: Auth::user()->email
                        );
                    }
                } else {
                    $correo = new EnvioMaterial($this->product);
                    Mail::to(Auth::user()->email)->send($correo);
                    $this->dispatch(
                        'sendSuccessHtml',
                        product: $this->product->title,
                        note: 'Se han enviado correctamente a: ',
                        email: Auth::user()->email
                    );
                }
            } else {
                $this->dispatch('error', message: 'No tiene permiso para enviar: ' . $this->product->title);
            }
        } catch (QueryException $e) {
            $this->dispatch('error', message: 'No se pudo enviar el archivo - ' . $this->product->title . ' - ' . $e->getMessage());
        } catch (FileNotFoundException $e) {
            $this->dispatch('error', message: 'El archivo no existe - ' . $this->product->title . ' - ' . $e->getMessage());
        } catch (CrossReferenceException $e) {
            $this->dispatch('error', message: 'No se pudo convertir el archivo - ' . $this->product->title . ' - ' . $e->getMessage());
        } catch (ErrorException  $e) {
            $this->dispatch('error', message: 'No se pudo enviar el archivo    - ' . $this->product->title . ' - ' . $e->getMessage());
        } catch (\Throwable $e) {
            $this->dispatch('error', message: 'Error al enviar el email - ' . $e->getMessage());
        } finally {
            $this->dispatch('alertDownload', message: "<span class='text-sm'><b>Importante !</b> - Si tiene problemas con la descarga, se recomienda descargar desde una computadora.</span>");
        }
    }
}
