<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Order;
use App\Models\Enviado;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use App\Mail\EnvioMaterial;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Models\Order_Details;
use Livewire\WithFileUploads;
use App\Http\Helpers\AddLicense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CartRender extends Component
{
    public $email, $whats, $face, $emailExist;
    public $web = false;
    public $payment;
    public $membershipExist;
    public $errorSeach;
    public  $userValidate;
    protected $listeners = [
        'cart-render-refresh' => '$refresh',
    ];

    use WithFileUploads;

    protected $messages = [
        'email.required' => 'El correo electrónico no puede estar vacío.',
        'whats.required' => 'El WhatsApp no puede estar vacío',
        'face.required' => 'El Facebook no puede estar vacío',
        'payment.required' => 'Debe cargar el comprobante de pago',
    ];


    public function render()
    {
        foreach (\Cart::getContent() as $item) {
            if ($item->associatedModel->model == 'Membership') {
                $this->membershipExist = true;
            }
        };




        return view('livewire.cart-render')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'cart',
                'title' => "Carrito",
                'navbarClass' => 'text-primary',
                'background' => '#eee !important'
            ])->section('content');
    }

    public function remove($id, $title)
    {
        try {
            \Cart::remove($id);
            foreach (\Cart::getContent() as $item) {
                if ($item->associatedModel->model == 'Membership') {
                    $this->membershipExist = true;
                } else {
                    $this->membershipExist = false;
                }
            };
            $this->dispatch('cart:update');
            $this->dispatch('deleteCartAlert', message: $title . " se ha eliminado del carrito");
            $this->dispatch('cart-render-refresh');
        } catch (\Throwable $th) {

            $this->dispatch('error', message: "Error al eliminar el producto " . $th->getMessage());
        }
    }


    public function loginMessage()
    {
        $this->dispatch('alertlogin', message: "<span class='text-sm'><b>Importante !</b> - Inicia sesión o registrate para finalizar la compra. </span>");
    }
    public function changeWeb()
    {
        $this->web == false ? $this->web = true : $this->web = false;
    }

    public function validateUser()
    {
        $user = User::where('email', $this->email)->first();
        if (!$user) {
            $this->dispatch(
                'confirmUserCreate',
                email: $this->email
            );
        } else {
            $this->dispatch('create-and-send');
        }
    }

    // public function validateEmail()
    // {
    //     $this->validate([
    //         'email' => 'required|string|email',
    //     ]);
    //     if ($this->email == '') {
    //         $this->errorSeach = true;
    //     } else {
    //         $this->userValidate = User::where('email', $this->email)->first();
    //         if ($this->userValidate) {
    //             $this->emailExist = true;
    //             $this->whats;
    //         } else {
    //             $this->emailExist = false;
    //         }
    //     }
    // }



    #[On('create-and-send')]
    public function submit()
    {
        if ($this->web == false) {
            if ($this->membershipExist) {
                $this->validate([
                    'email' => 'required|string|email',
                    'whats' => 'required|string',
                    'face' => 'required|string',
                    'payment' => 'required|image',
                ]);
            } else {
                $this->validate([
                    'email' => 'required|string|email',
                    'whats' => 'required|string',
                    'payment' => 'required|image',
                ]);
            }
        } else {
            if ($this->membershipExist) {
                $this->validate([
                    'email' => 'required|string|email',
                    'whats' => 'required|string',
                    'face' => 'required|string',
                ]);
            } else {
                $this->validate([
                    'email' => 'required|string|email',
                    'whats' => 'required|string',
                ]);
            }
        }


        try {
            //validar si el correo corresponde a algun usuario registrado
            $userExist = User::where('email', $this->email)->first();



            //si no existe el correo generar una cuenta de usuario
            if (!$userExist) {
                $password = Str::random(8);
                $encryptedPassword = bcrypt($password);
                //crear nuevo usario
                $user = User::create([
                    'name' => $this->email,
                    'email' => $this->email,
                    'password' => $encryptedPassword,
                    'whatsapp' => $this->whats,
                    'facebook' => $this->face,
                    'comment' => 'User created by admin ' . Auth::user()->id,
                ]);
            } else {
                $user = $userExist;
                if ($user->whatsapp) {
                    $user->update([
                        'whatsapp' => $this->whats,
                        'comment' => $user->comment . "- w before " . $user->whatsapp
                    ]);
                } else {
                    $user->update([
                        'whatsapp' => $this->whats,
                    ]);
                }
                if (!$user->facebook && $this->face != null) {
                    $user->update([
                        'facebook' => $this->face,
                    ]);
                } else {
                    $user->update([
                        'comment' => $user->comment . "- new face" . $user->face
                    ]);
                }
            }



            $newOrder = Order::create([
                'customer_id' => $user->id,
                'amount' => \Cart::getTotal(),
                'status' => 'create',
                'payment_type' => 'Externo'
            ]);
            $enviados = array(); //iniciar enviados vacio


            foreach (\Cart::getContent() as $item) {

                if ($item->associatedModel->model == 'Product') {
                    //guardar detalle de venta
                    Order_Details::create([
                        'order_id' => $newOrder->id,
                        'product_id' => $item->id,
                        'price' => $item->price,
                    ]);
                    $productSend = Product::find($item->id);

                    //validar si es un PDF y tiene folio activado
                    if ($productSend->format == 'pdf' && $productSend->folio == 1) {
                        //agregar licencia
                        $addLicense = new AddLicense($productSend->id, $newOrder->id);
                        if ($addLicense->setLicenseExternal()) {

                            set_time_limit(0);
                            //enviar correo con folio
                            $correo = new EnvioMaterial($productSend);
                            Mail::to($newOrder->user->email)->send($correo);

                            //guardar envio en base de datos de enviados
                            Enviado::create([
                                'email' => $newOrder->user->email,
                                'order_id' => $newOrder->id,
                                'product_id' => $productSend->id,
                            ]);
                        }
                    } else {
                        set_time_limit(0);
                        //enviar correo sin  folio

                        $correo = new EnvioMaterial($productSend);
                        Mail::to($newOrder->user->email)->send($correo);

                        //guardar envio en base de datos de enviados
                        Enviado::create([
                            'email' => $newOrder->user->email,
                            'order_id' => $newOrder->id,
                            'product_id' => $productSend->id,
                        ]);
                    }

                    array_push($enviados, '<br>' . $productSend->title); //agregar solo informacion
                }

                if ($item->associatedModel->model == 'Package') {
                    $packageSend = Package::find($item->id);
                    //guardar detalle de venta
                    Order_Details::create([
                        'order_id' => $newOrder->id,
                        'package_id' => $item->id,
                        'price' => $item->price,
                    ]);


                    foreach ($packageSend->products as $product) {

                        $productSend = Product::find($product->id);
                        //validar si es un PDF y tiene folio activado
                        if ($productSend->format == 'pdf' && $productSend->folio == 1) {
                            //agregar licencia
                            $addLicense = new AddLicense($productSend->id, $newOrder->id);
                            if ($addLicense->setLicenseExternal()) {

                                set_time_limit(0);
                                //enviar correo con folio
                                $correo = new EnvioMaterial($productSend);
                                Mail::to($newOrder->user->email)->send($correo);

                                //guardar envio en base de datos de enviados
                                Enviado::create([
                                    'email' => $newOrder->user->email,
                                    'order_id' => $newOrder->id,
                                    'product_id' => $productSend->id,
                                ]);
                            }
                        } else {
                            set_time_limit(0);
                            //enviar correo sin  folio

                            $correo = new EnvioMaterial($productSend);
                            Mail::to($newOrder->user->email)->send($correo);

                            //guardar envio en base de datos de enviados
                            Enviado::create([
                                'email' => $newOrder->user->email,
                                'order_id' => $newOrder->id,
                                'product_id' => $productSend->id,
                            ]);
                        }

                        array_push($enviados, '<br>' . $productSend->title); //agregar solo informacion

                    }
                }
                if ($item->associatedModel->model == 'Membership') {

                    $membershipSend = Membership::find($item->id);
                    //guardar detalle de venta
                    Order_Details::create([
                        'order_id' => $newOrder->id,
                        'membership_id' => $item->id,
                        'price' => $item->price,
                    ]);
                    array_push($enviados, '<br>' . $membershipSend->title . " (Solo registro)"); //agregar solo informacion
                }
            };



            \Cart::clear();
            $this->dispatch('cart:update');
            //actualizar status de orden, active orden y comprobante de pago
            $newOrder->update([
                'receiptPayment' => isset($this->payment) ? $this->payment->store('payments', 'public') : null,
                'status' => 'approved',
                'active' => true,
                'contacto' => $this->web ? 'Enviado sin comprobante -' . Auth::user()->name : ''
            ]);



            $this->dispatch(
                'sendSuccessHtmlMany',
                note: 'Se ha enviado correctamente a:',
                enviados: $enviados,
                email: $newOrder->user->email
            );
        } catch (\Throwable $th) {
            if ($th->getCode() == 23000) {
                $message = "El whatsApp o el facebook ya esta asignado a algun otro email.";
            } else {
                $message = $th->getMessage();
            }

            $this->dispatch('error', message: 'Error al enviar el email - ' . $message);
        }
    }
}
