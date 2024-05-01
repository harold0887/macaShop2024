<x-mail::message>
# Introduction

The body of your message.

Este es el id que se recibio en Webhooks: {{$idMercado}}

Motivo de envio: {{$type}}



Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
