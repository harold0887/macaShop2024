@component('mail::message')

## {{$userName}}, muchas gracias por su compra!!🫶🏻
Me alegra poder darle la bienvenida al grupo VIP de {{$membershipName}} !!🌈

Favor de dar clic al siguiente enlace para enviarnos un mensaje en WhatsApp y activar tu membresía.

@component('mail::button', ['url' => $url])
Activar membresía
@endcomponent


RESUMEN DE COMPRA: {{$order}}


## {{$title}}

CANTIDAD PAGADA: ${{$price}} MXN

FECHA DE COMPRA: {{date_format(now(),'d-M-Y')}}

VÁLIDO POR: Más de 100 recursos a lo largo del ciclo escolar.



Saludos,<br>
Material Didáctico MaCa
@endcomponent