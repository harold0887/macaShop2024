@component('mail::message')
# {{$userName}}, gracias por tu confianza y preferencia!!

## Adjunto se encuentra el documento: {{$subject}}.{{$format}} ##

<br>
Queda estrictamente prohibido:
<ul>
    <li>Revender el documento.</li>
    <li>Editar o alterar alguna parte del documento.</li>
    <li>Compartir el archivo en algún sitio web, red social o WhatsApp.</li>
    <li>Reproducir total o parcial este documento, bajo cualquiera de sus formas, electrónica u otras, sin la autorización por escrito de Material Didáctico MaCa. </li>
</ul>







@component('mail::panel')

<small>
    Si tienes alguna pregunta, no dudes en contactarme. Solo da click en el logo de WhatsApp
</small>
<br>
<a href="https://wa.me/message/GUNXZZ666PN3I1" target="_blank">
    <img src="materialdidacticomaca.com/img/whatsapp1.png" alt="logo WhatsApp" width="50">
</a>

@endcomponent
<small>
    Todos nuestros documentos estan protegidos con derechos de autor y tienen un folio único. Material Didáctico MaCa se reserva la facultad de presentar las acciones civiles o penales que considere necesarias por la utilización indebida de los materiales adquiridos y sus contenidos.
</small>

@endcomponent