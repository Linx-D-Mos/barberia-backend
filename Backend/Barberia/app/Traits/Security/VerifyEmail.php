<?php

namespace App\Traits\Security;

use App\Mail\VerifyEmail as MailVerifyEmail;
use App\Models\Code;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

trait VerifyEmail
{
    /**
     * Envía un código de verificación al correo electrónico proporcionado.
     *
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se encuentra un usuario con el correo electrónico proporcionado.
     * @throws \Exception Si ocurre un error al enviar el correo electrónico.
     *
     * Este método realiza las siguientes acciones:
     * 1. Genera un código de verificación aleatorio de 6 dígitos.
     * 2. Envía un correo electrónico al usuario con el código de verificación.
     * 3. Guarda o actualiza el código de verificación en la base de datos junto con la fecha y hora de creación.
     */
    public function sendVerificationCode()
    {
        $verification_code = rand(100000, 999999);

        Mail::to($this)->send(new MailVerifyEmail($this, $verification_code));

        $created_at = Carbon::now()->format('Y-m-d H:i:s');

        Code::updateOrCreate(
            ['email' => $this->email],
            [
                'email' => $this->email,
                'code' => $verification_code,
                'created_at' => $created_at,
            ]
        );
    }

    /**
     * Verifica si el código de verificación proporcionado es correcto.
     *
     * @param int $_code El código de verificación proporcionado.
     *
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se encuentra un código de verificación asociado al correo electrónico proporcionado.
     *
     * Este método realiza las siguientes acciones:
     * 1. Busca un código de verificación en la base de datos con el correo electrónico proporcionado.
     * 2. Compara el código de verificación proporcionado con el código de verificación almacenado en la base de datos.
     * 3. Si los códigos coinciden, se elimina el código de verificación de la base de datos.
     * 4. Si los códigos no coinciden, se lanza una excepción.
     */
    public function verifyCode($_code)
    {
        $code = Code::where('email', $this->email)->firstOrFail();

        if ($code->code == $_code) {
            $code->delete();

            return true;
        }

        return false;
    }

    /**
     * Verifica si el correo electrónico del cliente ha sido verificado.
     *
     * @return bool Devuelve true si el correo electrónico ha sido verificado, de lo contrario, devuelve false.
     */
    public function hasVerifiedEmail()
    {
        if ($this->email_verified_at) {
            return true;
        }

        return false;
    }
}
