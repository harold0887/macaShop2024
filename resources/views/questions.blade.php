@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => '',
'title' =>"Aviso de privacidad",
'pageBackground' => asset("material").'/img/login.jpg',
'navbarClass'=>'text-primary',
'background'=>'#eee !important'
])

@section('content')

<div class="container ">
    <div class="content py-0 bg-white">

        <div class="row mt-3 justify-content-center">
            <div class="col-12 col-lg-12">
                <p class="  pt-6 font-serif lg:text-2xl lg:pt-1 md:text-3xl md:font-bold text-center text-2xl  text-primary text-center text-gray-1000 mt-0 text-base md:text-base">Preguntas Frecuentes</p>
            </div>
            <div class="col-12 col-md-8">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                ¿Que es una Membresía VIP?
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-mdb-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Con la membresia tiene acceso a materiales exclusivos que puede descargar de manera inmediata, cuadernillos de apoyo, exámenes, material de Lectoescritura, cuadernillos de repaso, juegos interactivos y mucho más.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                ¿Cuáles son los Métodos de Pago?
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-mdb-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Utilizamos la plataforma de pagos de Mercado Pago, la cual acepta las siguientes formas de pago:
                                <ul>

                                    <li>Tarjeta de crédito o debito (Visa, Mastercard y American Express)</li>
                                    <li>Efectivo (Oxxo, Seven, Circle K, Soriana, Farmaria del ahorro, entre muchos otros)</li>
                                    <li>Transferencia electrónica</li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                ¿Los pagos son Seguros?
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-mdb-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Hemos Invertido en los sistemas de protección más avanzados para tu compra, es por ello que mantenemos las transacciones altamente protegidas de principio a fin. Utilizamos la plataforma de Mercado Pago, encriptamos los datos en forma segura y así cumplimos con los más altos estándares de seguridad online.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingFour">
                            <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                ¿Se puede pagar con PayPal?
                            </button>
                        </h2>
                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-mdb-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Sí, nuestra plataforma de pagos acepta Paypal, a demás de ser uno de los métodos de pago más seguros.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingFive">
                            <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                ¿Puedo cancelar la membresia?
                            </button>
                        </h2>
                        <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-mdb-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Nuestra membresia es de pago unico por lo cual una vez que realiza el pago tiene acceso a todos los recursos disponibles de la mebresia, esto nos impide cancelar la suscripcion.
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingSix">
                                <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                                    ¿Los materiales son solo de preescolar ?
                                </button>
                            </h2>
                            <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-mdb-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Nuestros recursos son de preescolar 1,2,3 asi como primero, segundo y tercer grado de primaria.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingSeven">
                                <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                                    ¿Cómo es el proceso de compra?
                                </button>
                            </h2>
                            <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-mdb-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ol>
                                        <li>Selecciona el material de su interés.</li>
                                        <li>Da click en el boton de agregar al carrito (puede agregar varios productos).</li>
                                        <li>Una vez agregados todos los productos de su interés, debe ir al carrito de compras</li>
                                        <li>Revisa tu pedido y luego continúe con el pago.</li>
                                        <li>Selecciona la forma de pago.
                                            <ul>
                                                <li>Tarjeta de credito o debito, solo debe ingresar los datos de la tarjeta.</li>
                                                <li>Efectivo, seleccione donde quiere pagar.</li>
                                                <li>Tranferencia, seleccione su banco.</li>
                                            </ul>
                                        </li>
                                        <li>Una vez realizado el pago, puede ver el estatus del pago y el detalle de la compra en mi cuenta.</li>
                                        <li>Si el pago ya fue aprobado por mercado pago, puede descargar los materiales disponibles.</li>
                                    </ol>




                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>


        </div>
        <div class="row justify-content-center my-5">

            <div class="col-12 col-md-5  text-center ">
                <h2 class="pt-6 font-serif lg:text-2xl lg:pt-12 md:text-3xl md:font-bold text-center text-2xl  text-primary ">
                    ¿Tienes más preguntas?
                </h2>
                <span class="d-inline">
                    <p class="text-center text-gray-1000 mt-0 text-base md:text-base">
                        Envianos un mensaje, solo da click en el logo de WhatsApp
                    </p>
                </span>
                <a href="https://wa.me/message/GUNXZZ666PN3I1" target="_blank">
                    <img class=" d-inline" src="{{ asset('img/whatsapp.png') }} " width="60">
                </a>
            </div>
        </div>

    </div>
</div>


@endsection