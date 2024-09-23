<x-mail::message>
# Código de Verificación

Hola {{ $user->name }}, este es su código de verificación para que continúe con su registro.


<p class="codigo" style="text-align: center; font-size: 25px; color: black;">
<label style="padding: 10px; background-color: #ebebeb">
{{ $code }}
</label>
</p>


Gracias por usar nuestra aplicación.<br>
{{ config('app.name') }}
</x-mail::message>
