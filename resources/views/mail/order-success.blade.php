@component('mail::message')


## {{$name}}, muchas gracias por su compra!!🫶🏻 ##

RESUMEN DE COMPRA: {{$order}}

CANTIDAD PAGADA: ${{$price}} MXN

FECHA DE COMPRA: {{date_format($date,'d-M-Y')}}


<x-mail::table>
    | Producto | Precio |
    | ------------- | --------:|
    @if(isset($memberships) && $memberships->count() > 0)
    @foreach($memberships as $item)
    | Membresía {{ $item->membership->title }} | {{$item->price}} |
    @endforeach
    @endif
    @if(isset($packages) && $packages->count() > 0)
    @foreach($packages as $item)
    | {{$item->package->title}} | {{$item->price}} |
    @endforeach
    @endif
    @if(isset($products) && $products->count() > 0)
    @foreach($products as $item)
    | {{$item->product->title}} | {{$item->price}} |
    @endforeach
    @endif
    | | |
    | Total | {{$price}} |
</x-mail::table>




Sigue estos pasos para descargar los materiales didácticos.

<ol>
    <li>Iniciar sesión con tu usuario y contraseña</li>
    <li>Ingresar a la sección de “Mis compras”.</li>
    <li>Da click en el botón detalle de compra.</li>
    <li>Da click en el botón descargar o enviar a email.</li>
    <li>Disfruta el material didáctico.</li>
</ol>
<hr>
Queda estrictamente prohibido:
<ul>
    <li>Revender el documento.</li>
    <li>Editar o alterar alguna parte del documento.</li>
    <li>Compartir el archivo en algún sitio web, red social o WhatsApp.</li>
    <li>Reproducir total o parcial este documento, bajo cualquiera de sus formas, electrónica u otras, sin la autorización por escrito de Material Didáctico MaCa. </li>
</ul>

<br>
<small>
    Todos nuestros documentos estan protegidos con derechos de autor y tienen un folio único. Material Didáctico MaCa se reserva la facultad de presentar las acciones civiles o penales que considere necesarias por la utilización indebida de los materiales adquiridos y sus contenidos.
</small>

<br>
<br>


@component('mail::panel')

<small>
    Si tiene alguna pregunta, no dude en contactarme. Solo da click en el logo de WhatsApp
</small>
<br>
<div class="justify-contente-center border">
    <a href="https://wa.me/message/GUNXZZ666PN3I1" target="_blank">
        <img src="materialdidacticomaca.com/img/whatsapp1.png" alt="logo WhatsApp" width="50">
    </a>
</div>

@endcomponent


Saludos,<br>
Material Didáctico MaCa
@endcomponent