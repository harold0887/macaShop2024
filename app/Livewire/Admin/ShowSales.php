<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Enviado;
use App\Models\Package;

use App\Models\Product;
use Livewire\Component;

use App\Mail\EnvioMaterial;
use Livewire\Attributes\On;
use App\Models\Order_Details;
use Livewire\WithFileUploads;
use App\Http\Helpers\AddLicense;
use App\Models\PackageAsProduct;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Request;

class ShowSales extends Component
{
    public $patch, $ids, $order, $idPackage, $count = 0;
    public $socialNetwork;
    public $payment;
    public $web = false;
    public  $products, $productsSum, $packages, $memberships, $packagesSelect, $packagesSum, $membershipsSum;

    public $enviados;
    use WithFileUploads;
    protected $rules = [
        'payment' => 'required|image',

    ];
    protected $messages = [
        'payment.required' => 'Debe cargar el comprobante de pago',
    ];
    protected $listeners = ['some-event3' => '$refresh'];



    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
        $this->order = Order::findOrFail($this->ids);
        $this->idPackage = 1000;
        $this->socialNetwork = $this->order->contacto;

        //dd($this->order);
    }
    public function render()
    {
        $this->products = Order_Details::ShowOrderProducts($this->order->id)->get();
        $this->productsSum = Order_Details::ShowOrderProducts($this->order->id)->sum('price');

        $this->packages = Order_Details::ShowOrderPackages($this->order->id)->get();
        $this->packagesSum = Order_Details::ShowOrderPackages($this->order->id)->sum('price');

        $this->memberships = Order_Details::ShowOrderMemberships($this->order->id)->get();
        $this->membershipsSum = Order_Details::ShowOrderMemberships($this->order->id)->sum('price');

        $this->packagesSelect = Package::where('id', $this->idPackage)->first();


        $this->enviados = Enviado::where('order_id', $this->order->id)
            ->orderBy('created_at', 'desc')
            ->get();


        return view('livewire.admin.show-sales');
    }

    public function showPackages($idPackage)
    {
        $this->idPackage = $idPackage;
    }

    public function download(Product $product)
    {
        try {
            if ($product->format == 'pdf') {
                $addLicense = new AddLicense($product->id, $this->order->id);
                if ($addLicense->download()) {

                    $file = "pdf/newpdf.pdf";
                    return response()->download($file, "w" . $this->order->user->id . ' - ' . $product->title . " © Material didáctico MaCa.pdf");
                }
            } else {
                $this->dispatch('error', message: 'Error al descargar el documento -  No es un PDF');
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'error al descargar el documento - ' . $th->getMessage());
        }
    }

    public function downloadExternal(Product $product)
    {
        try {
            if ($product->format == 'pdf') {
                $addLicense = new AddLicense($product->id, $this->order->id);
                if ($addLicense->setLicenseExternal()) {

                    $file = "pdf/newpdf.pdf";
                    return response()->download($file, "w" . $this->order->user->id . ' - ' . $product->title . " © Material didáctico MaCa.pdf");
                }
            } else {
                $this->dispatch('error', message: 'Error al descargar el documento -  No es un PDF');
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'error al descargar el documento - ' . $th->getMessage());
        }
    }

    public function submit()
    {

        if ($this->web == false) {
            $this->validate();
        }
        $enviados = array(); //iniciar enviados vacio




        try {
            //recorrer y enviar productos de la orden
            foreach ($this->products as $item) {
                $productSend = Product::findOrFail($item->product->id);

                //validar si es un PDF y tiene folio activado
                if ($productSend->format == 'pdf' && $productSend->folio == 1) {
                    //agregar licencia
                    $addLicense = new AddLicense($productSend->id, $this->order->id);
                    if ($addLicense->setLicenseExternal()) {

                        set_time_limit(0);
                        //enviar correo con folio
                        $correo = new EnvioMaterial($productSend);
                        Mail::to($this->order->user->email)->send($correo);

                        //guardar envio en base de datos de enviados
                        Enviado::create([
                            'email' => $this->order->user->email,
                            'order_id' => $this->order->id,
                            'product_id' => $productSend->id,
                        ]);
                    }
                } else {
                    set_time_limit(0);
                    //enviar correo sin  folio

                    $correo = new EnvioMaterial($productSend);
                    Mail::to($this->order->user->email)->send($correo);

                    //guardar envio en base de datos de enviados
                    Enviado::create([
                        'email' => $this->order->user->email,
                        'order_id' => $this->order->id,
                        'product_id' => $productSend->id,
                    ]);
                }

                array_push($enviados, '<br>' . $productSend->title); //agregar solo informacion
            }


            //recorrer los paquetes comprados y luego recorrer cada paquete para obtener los productos y enviarlos
            foreach ($this->packages as $package) {
                $packageSend = Package::findOrFail($package->package_id);
                foreach ($packageSend->products as $item) {
                    $productSend = Product::findOrFail($item->id);
                    //validar si es un PDF y tiene folio activado
                    if ($productSend->format == 'pdf' && $productSend->folio == 1) {
                        //agregar licencia
                        $addLicense = new AddLicense($productSend->id, $this->order->id);
                        if ($addLicense->setLicenseExternal()) {

                            set_time_limit(0);
                            //enviar correo con folio
                            $correo = new EnvioMaterial($productSend);
                            Mail::to($this->order->user->email)->send($correo);

                            //guardar envio en base de datos de enviados
                            Enviado::create([
                                'email' => $this->order->user->email,
                                'order_id' => $this->order->id,
                                'product_id' => $productSend->id,
                            ]);
                        }
                    } else {
                        set_time_limit(0);
                        //enviar correo sin  folio

                        $correo = new EnvioMaterial($productSend);
                        Mail::to($this->order->user->email)->send($correo);

                        //guardar envio en base de datos de enviados
                        Enviado::create([
                            'email' => $this->order->user->email,
                            'order_id' => $this->order->id,
                            'product_id' => $productSend->id,
                        ]);
                    }

                    array_push($enviados, '<br>' . $productSend->title); //agregar solo informacion
                }
            }




            //actualizar status de orden, active orden y comprobante de pago
            $this->order->update([
                'receiptPayment' => isset($this->payment) ? $this->payment->store('payments', 'public') : null,
                'status' => 'approved',
                'active' => true,
                'contacto' => $this->web ? 'Enviado sin comprobante -' . Auth::user()->name : ''
            ]);
            $this->dispatch(
                'sendSuccessHtmlMany',
                note: 'Se ha enviado correctamente a:',
                enviados: $enviados,
                email: $this->order->user->email
            );
            $this->dispatch('some-event3');
        } catch (\Throwable $e) {
            $this->dispatch('error', message: 'Error al enviar el email - ' . $e->getMessage());
        }
    }

    public function changeWeb()
    {

        $this->web == false ? $this->web = true : $this->web = false;
    }
    #[On('resend-product')]
    public function resendProduct($id)
    {
        $productSend = Product::find($id);
        try {
            //validar si es un PDF y tiene folio activado
            if ($productSend->format == 'pdf' && $productSend->folio == 1) {
                //agregar licencia
                $addLicense = new AddLicense($productSend->id, $this->order->id);
                if ($addLicense->setLicenseExternal()) {

                    set_time_limit(0);
                    //enviar correo con folio
                    $correo = new EnvioMaterial($productSend);
                    Mail::to($this->order->user->email)->send($correo);

                    //guardar envio en base de datos de enviados
                    Enviado::create([
                        'email' => $this->order->user->email,
                        'order_id' => $this->order->id,
                        'product_id' => $productSend->id,
                    ]);
                    $this->dispatch(
                        'sendSuccessHtml',
                        product: $productSend->title,
                        note: 'Se ha reenviado correctamente a: ',
                        email: $this->order->user->email
                    );
                }
            } else {
                set_time_limit(0);
                //enviar correo sin  folio

                $correo = new EnvioMaterial($productSend);
                Mail::to($this->order->user->email)->send($correo);

                //guardar envio en base de datos de enviados
                Enviado::create([
                    'email' => $this->order->user->email,
                    'order_id' => $this->order->id,
                    'product_id' => $productSend->id,
                ]);
                $this->dispatch(
                    'sendSuccessHtml',
                    product: $productSend->title,
                    note: 'Se ha reenviado correctamente a: ',
                    email: $this->order->user->email
                );
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Error al reenviar el email - ' . $th->getMessage());
        }
    }
    #[On('resend-package')]
    public function resendPackage($id)
    {
        $packageSend = Package::findOrFail($id);
        $enviados = array(); //iniciar enviados vacio


        try {
            foreach ($packageSend->products as $item) {
                $productSend = Product::findOrFail($item->id);
                //dd($productSend);
                //validar si es un PDF y tiene folio activado
                if ($productSend->format == 'pdf' && $productSend->folio == 1) {
                    //agregar licencia
                    $addLicense = new AddLicense($productSend->id, $this->order->id);
                    if ($addLicense->setLicenseExternal()) {

                        set_time_limit(0);
                        //enviar correo con folio
                        $correo = new EnvioMaterial($productSend);
                        Mail::to($this->order->user->email)->send($correo);

                        //guardar envio en base de datos de enviados
                        Enviado::create([
                            'email' => $this->order->user->email,
                            'order_id' => $this->order->id,
                            'product_id' => $productSend->id,
                        ]);
                    }
                } else {
                    set_time_limit(0);
                    //enviar correo sin  folio

                    $correo = new EnvioMaterial($productSend);
                    Mail::to($this->order->user->email)->send($correo);

                    //guardar envio en base de datos de enviados
                    Enviado::create([
                        'email' => $this->order->user->email,
                        'order_id' => $this->order->id,
                        'product_id' => $productSend->id,
                    ]);
                }

                array_push($enviados, '<br>' . $productSend->title); //agregar solo informacion
            }
            $this->dispatch(
                'sendSuccessHtmlMany',
                note: 'Se ha enviado correctamente a:',
                enviados: $enviados,
                email: $this->order->user->email
            );
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Error al reenviar el email - ' . $th->getMessage());
        }
    }

    //solo cargar comprobante de pago
    public function uploadPayment()
    {
        $this->validate();

        try {
            //actualizar el comprobante de pago
            $this->order->update([
                'receiptPayment' => isset($this->payment) ? $this->payment->store('payments', 'public') : null,
            ]);
            $this->dispatch(
                'success-auto-close',
                message: 'Se ha guardado el pago de manera correcta.'
            );
            $this->dispatch('some-event3');
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Error al guardar el comprobante de pago - ' . $th->getMessage());
        }
    }
}
