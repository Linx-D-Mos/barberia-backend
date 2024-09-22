<x-mail::message>
# Reestablecer Contraseña

Hola {{ $user->name }}, este es su código de verificación para que reestablezca su contraseña.


<p class="codigo" style="text-align: center; font-size: 25px; color: black;">
<label style="padding: 10px; background-color: #ebebeb">
{{ $reset_password_code }}
</label>
</p>


Gracias por usar nuestra aplicación.<br>
{{ config('app.name') }}
</x-mail::message>