<?php

namespace App\Traits\Security;

use App\Mail\ResetPassword as MailResetPassword;
use App\Models\Code;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

trait ResetPassword
{
    /**
     * Envía un código de restablecimiento de contraseña al correo electrónico proporcionado.
     *
     * @param string $email El correo electrónico del usuario que solicita el restablecimiento de contraseña.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se encuentra un usuario con el correo electrónico proporcionado.
     * @throws \Exception Si ocurre un error al enviar el correo electrónico.
     * 
     * @return void
     */
    public function sendResetPasswordCode(string $email)
    {
        $reset_password_code = rand(100000, 999999);

        $user = User::where('email', $email)->firstOrFail();

        Mail::to($this)->send(new MailResetPassword($user, $reset_password_code));

        $created_at = Carbon::now()->format('Y-m-d H:i:s'); 

        Code::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'code' => $reset_password_code,
                'created_at' => $created_at,
            ]
        );
    }

    /**
     * Verifica el código de restablecimiento de contraseña.
     *
     * Este método busca un código de restablecimiento de contraseña asociado a un correo electrónico
     * específico y lo compara con el código proporcionado. Si el código coincide, se elimina el código
     * de la base de datos y se devuelve true. Si no coincide, se devuelve false.
     *
     * @param string $email El correo electrónico asociado al código de restablecimiento de contraseña.
     * @param int $reset_password_code El código de restablecimiento de contraseña proporcionado.
     * @return bool true si el código coincide y se elimina, false en caso contrario.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se encuentra un código asociado al correo electrónico.
     */
    public function verifyResetPasswordCode(string $email, int $reset_password_code)
    {
        $code = Code::where('email', $email)->firstOrFail();

        if ($code->code === $reset_password_code) {
            $code->delete();
            return true;
        }

        return false;
    }
}
