<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PhotoController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/photo/upload",
     *     operationId="SubirFoto",
     *     tags={"Foto"},
     *     summary="Subir foto de perfil", 
     *     description="Subir foto de perfil para un usuario autenticado y verificado.",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="photo",
     *                     type="string",
     *                     format="binary",
     *                     description="Archivo de imagen (jpeg, png, jpg, gif, svg, bmp, webp)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Genial! Tu foto de perfil ha sido subida exitosamente."),
     *     @OA\Response(response=422, description="Error de validación, verifique los campos"),
     * )
     */
    public function uploadPhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => [
                'required',
                'string',
                'max:2097152', // 2MB en bytes
                function ($attribute, $value, $fail) {
                    $allowed_types = ['jpeg', 'png', 'jpg', 'gif', 'svg', 'bmp', 'webp'];
                    $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $value));
                    $f = finfo_open();
                    $mime_type = finfo_buffer($f, $image_data, FILEINFO_MIME_TYPE);
                    finfo_close($f);
                    $extension = explode('/', $mime_type)[1];
                    if (!in_array($extension, $allowed_types)) {
                        $fail("El campo photo debe ser un archivo de tipo: " . implode(', ', $allowed_types) . ".");
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación, verifique los campos',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Obtener el usuario autenticado
        $user = $request->user();

        // Eliminar la foto anterior
        if ($user->photo) {
            $name = basename($user->photo);
            Storage::disk('s3')->delete('profiles/' . $name);
        }


        // Procesar la imagen
        $photo = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->photo));

        // nombre de la foto
        $photoName = $user->phone . '.png';

        // subir la foto al bucket de S3
        Storage::disk('s3')->put('profiles/' . $photoName, $photo);

        // obtener la url de la foto
        $url = Storage::url('profiles/' . $photoName);

        // actualizar la foto de perfil del usuario
        $user->update([
            'photo' => $url,
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Genial! Tu foto de perfil ha sido subida exitosamente.',
            'photo_url' => $url,
        ], 200);
    }
}
