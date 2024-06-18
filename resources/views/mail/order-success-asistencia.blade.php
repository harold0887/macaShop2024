@component('mail::message')

## {{$userName}}, muchas gracias por su compra!!🫶🏻
Me alegra poder darle la bienvenida al {{$membershipName}} !!🌈



RESUMEN DE COMPRA: {{$order}}


## {{$title}}

CANTIDAD PAGADA: ${{$price}} MXN

FECHA DE COMPRA: {{date_format($date,'d-M-Y')}}

<!-- VÁLIDO POR: Más de 100 recursos a lo largo del ciclo escolar. -->



Saludos,<br>
Material Didáctico MaCa
@endcomponent