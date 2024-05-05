@component('mail::message')


## ¡Hola, {{$userName}}! 🫶🏻

Olvidaste estos materiales didácticos en tu carrito de compras y los reservamos para ti. ¡Para tu comodidad puedes finalizar el pago en un solo click y obtener un 10% de descuento!🌈



@component('mail::button', ['url' => $url])
Pagar ahora
@endcomponent


Resumen de orden: *{{$order}}*
<br>
<br>
Subtotal: *${{$subtotal}} MXN*
<br>
Descuento: *${{$descuento}}.00 MXN*
<br>
Total: *${{$total}}.00 MXN*


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
    | Total | {{$subtotal}} |
</x-mail::table>

<small>
    Nota: El descuento únicamente aplica pagando con el link enviado en este email.
</small>
@component('mail::panel')

<small>
    Si tienes alguna pregunta, no dudes en contactarme. Solo da click en el logo de WhatsApp
</small>
<br>
<a href="https://wa.me/message/GUNXZZ666PN3I1" target="_blank">
    <img src="materialdidacticomaca.com/img/whatsapp1.png" alt="logo WhatsApp" width="50">
</a>

@endcomponent

Saludos,<br>
Material Didáctico MaCa
@endcomponent