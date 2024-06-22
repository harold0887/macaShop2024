<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Enviado;
use App\Models\Package;

use App\Models\Product;
use Livewire\Component;

use App\Mail\EnvioMaterial;
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
    public  $packages, $memberships, $productsPackagesOrder, $packagesSum, $membershipsSum;
    public $products, $productsSum;
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

        $this->enviados = Enviado::where('order_id', $this->order->id)
            ->orderBy('created_at', 'desc')
            ->get();





        // $this->packages = Package::join('order_details', 'order_details.package_id', '=', 'packages.id')
        //     ->join('orders', 'order_details.order_id', '=', 'orders.id')
        //     ->where('order_details.order_id', $this->ids)
        //     ->orderBy('packages.title')
        //     ->select('packages.id', 'packages.model', 'packages.itemMain', 'packages.price', 'packages.title', 'orders.active', 'orders.id as order_id')
        //     ->get();

        // $this->packagesSum = Package::join('order_details', 'order_details.package_id', '=', 'packages.id')
        //     ->join('orders', 'order_details.order_id', '=', 'orders.id')
        //     ->where('order_details.order_id', $this->ids)
        //     ->orderBy('packages.title')
        //     ->select('packages.id')
        //     ->sum('order_details.price');



        $this->memberships = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('memberships', 'order_details.membership_id', '=', 'memberships.id')
            ->where('order_details.order_id', $this->ids)
            ->orderBy('memberships.title')
            ->select(
                'memberships.id',
                'memberships.itemMain',
                'order_details.price',
                'memberships.title',
                'orders.active',
                'orders.id as order_id',
                'order_details.id as idOrder'
            )->get();
        $this->membershipsSum = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('memberships', 'order_details.membership_id', '=', 'memberships.id')
            ->where('order_details.order_id', $this->ids)
            ->orderBy('memberships.title')
            ->select(
                'memberships.id'
            )
            ->sum('order_details.price');

        $this->productsPackagesOrder = PackageAsProduct::join('products', 'package_product.product_id', 'products.id')
            ->where('package_product.package_id', $this->idPackage)
            ->select('products.title', 'products.id', 'products.itemMain', 'products.price', 'products.status', 'products.folio')
            ->orderBy('title')
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

                    return response()->download($file, "w" . $this->order->user->id . ' - ' . $product->title . ".pdf");
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
                $productSend = Product::find($item->product->id);

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

    public function resendProduct(Product $product)
    {
        try {
            //validar si es un PDF y tiene folio activado
            if ($product->format == 'pdf' && $product->folio == 1) {
                //agregar licencia
                $addLicense = new AddLicense($product->id, $this->order->id);
                if ($addLicense->setLicenseExternal()) {

                    set_time_limit(0);
                    //enviar correo con folio
                    $correo = new EnvioMaterial($product);
                    Mail::to($this->order->user->email)->send($correo);

                    //guardar envio en base de datos de enviados
                    Enviado::create([
                        'email' => $this->order->user->email,
                        'order_id' => $this->order->id,
                        'product_id' => $product->id,
                    ]);
                    $this->dispatch(
                        'sendSuccessHtml',
                        product: $product->title,
                        note: 'Se ha reenviado correctamente a: ',
                        email: Auth::user()->email
                    );
                }
            } else {
                set_time_limit(0);
                //enviar correo sin  folio

                $correo = new EnvioMaterial($product);
                Mail::to($this->order->user->email)->send($correo);

                //guardar envio en base de datos de enviados
                Enviado::create([
                    'email' => $this->order->user->email,
                    'order_id' => $this->order->id,
                    'product_id' => $product->id,
                ]);
                $this->dispatch(
                    'sendSuccessHtml',
                    product: $product->title,
                    note: 'Se ha reenviado correctamente a: ',
                    email: Auth::user()->email
                );
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Error al reenviar el email - ' . $th->getMessage());
        }
    }
}
