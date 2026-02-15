<?php

namespace App\Http\Controllers;

use App\Models\Ritmo;
use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VideoController extends Controller
{
    public function __construct(
        private VideoService $videoService
    ) {}

    public function store(Request $request, Ritmo $ritmo)
    {
        Gate::authorize('create', Video::class);

        // Validar con mensajes personalizados
        $validated = $request->validate([
            'tambor_id' => ['required', 'exists:tambores,id'],
            'url_video' => ['nullable', 'url'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,webm,ogg', 'max:102400'], // 100MB en kilobytes
            'orden_ejecucion' => ['required', 'integer', 'min:0'],
        ], [
            'tambor_id.required' => 'Debe seleccionar un tambor.',
            'tambor_id.exists' => 'El tambor seleccionado no existe.',
            'url_video.url' => 'La URL del video no es válida.',
            'video_file.file' => 'El archivo debe ser un archivo válido.',
            'video_file.mimes' => 'El archivo debe ser un video (formato: mp4, webm u ogg).',
            'video_file.max' => 'El archivo no debe ser mayor a 100MB.',
            'orden_ejecucion.required' => 'El orden de ejecución es requerido.',
            'orden_ejecucion.integer' => 'El orden de ejecución debe ser un número entero.',
            'orden_ejecucion.min' => 'El orden de ejecución debe ser mayor o igual a 0.',
        ]);

        // Verificar que se proporcione al menos una URL o un archivo
        $hasFile = $request->hasFile('video_file');
        $hasUrl = !empty($validated['url_video']);

        if (!$hasFile && !$hasUrl) {
            return redirect()->back()
                ->withErrors(['video_file' => 'Debes proporcionar una URL o subir un archivo de video.'])
                ->withInput();
        }

        // Si hay archivo, verificar que es válido
        if ($hasFile) {
            $archivo = $request->file('video_file');
            
            if (!$archivo) {
                return redirect()->back()
                    ->withErrors(['video_file' => 'No se pudo obtener el archivo. Verifique que el formulario tenga enctype="multipart/form-data".'])
                    ->withInput();
            }

            if (!$archivo->isValid()) {
                $errorCode = $archivo->getError();
                $errorMessage = match($errorCode) {
                    UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'El archivo es demasiado grande. El tamaño máximo permitido es 100MB.',
                    UPLOAD_ERR_PARTIAL => 'El archivo se subió parcialmente. Intente nuevamente.',
                    UPLOAD_ERR_NO_FILE => 'No se seleccionó ningún archivo.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Error del servidor: falta el directorio temporal.',
                    UPLOAD_ERR_CANT_WRITE => 'Error del servidor: no se pudo escribir el archivo.',
                    UPLOAD_ERR_EXTENSION => 'Error del servidor: una extensión de PHP detuvo la subida del archivo.',
                    default => 'El archivo no es válido o no se pudo subir. Código de error: ' . $errorCode,
                };
                
                return redirect()->back()
                    ->withErrors(['video_file' => $errorMessage])
                    ->withInput();
            }

            // Verificar el tipo MIME del archivo
            $mimeType = $archivo->getMimeType();
            $allowedMimes = ['video/mp4', 'video/webm', 'video/ogg', 'video/quicktime'];
            if (!in_array($mimeType, $allowedMimes)) {
                return redirect()->back()
                    ->withErrors(['video_file' => 'El archivo debe ser un video (MP4, WebM u OGG). Tipo detectado: ' . $mimeType])
                    ->withInput();
            }
        }

        $validated['ritmo_id'] = $ritmo->id;

        if ($hasFile) {
            $this->videoService->create($validated, $request->file('video_file'));
        } else {
            $this->videoService->create($validated);
        }

        return redirect()->back()
            ->with('success', 'Video agregado exitosamente.');
    }

    public function update(Request $request, Video $video)
    {
        Gate::authorize('update', $video);

        // Validar con mensajes personalizados
        $validated = $request->validate([
            'tambor_id' => ['required', 'exists:tambores,id'],
            'url_video' => ['nullable', 'url'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,webm,ogg', 'max:102400'], // 100MB en kilobytes
            'orden_ejecucion' => ['required', 'integer', 'min:0'],
        ], [
            'tambor_id.required' => 'Debe seleccionar un tambor.',
            'tambor_id.exists' => 'El tambor seleccionado no existe.',
            'url_video.url' => 'La URL del video no es válida.',
            'video_file.file' => 'El archivo debe ser un archivo válido.',
            'video_file.mimes' => 'El archivo debe ser un video (formato: mp4, webm u ogg).',
            'video_file.max' => 'El archivo no debe ser mayor a 100MB.',
            'orden_ejecucion.required' => 'El orden de ejecución es requerido.',
            'orden_ejecucion.integer' => 'El orden de ejecución debe ser un número entero.',
            'orden_ejecucion.min' => 'El orden de ejecución debe ser mayor o igual a 0.',
        ]);

        // Si hay archivo, verificar que es válido
        if ($request->hasFile('video_file')) {
            $archivo = $request->file('video_file');
            
            if (!$archivo) {
                return redirect()->back()
                    ->withErrors(['video_file' => 'No se pudo obtener el archivo. Verifique que el formulario tenga enctype="multipart/form-data".'])
                    ->withInput();
            }

            if (!$archivo->isValid()) {
                $errorCode = $archivo->getError();
                $errorMessage = match($errorCode) {
                    UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'El archivo es demasiado grande. El tamaño máximo permitido es 100MB.',
                    UPLOAD_ERR_PARTIAL => 'El archivo se subió parcialmente. Intente nuevamente.',
                    UPLOAD_ERR_NO_FILE => 'No se seleccionó ningún archivo.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Error del servidor: falta el directorio temporal.',
                    UPLOAD_ERR_CANT_WRITE => 'Error del servidor: no se pudo escribir el archivo.',
                    UPLOAD_ERR_EXTENSION => 'Error del servidor: una extensión de PHP detuvo la subida del archivo.',
                    default => 'El archivo no es válido o no se pudo subir. Código de error: ' . $errorCode,
                };
                
                return redirect()->back()
                    ->withErrors(['video_file' => $errorMessage])
                    ->withInput();
            }

            // Verificar el tipo MIME del archivo
            $mimeType = $archivo->getMimeType();
            $allowedMimes = ['video/mp4', 'video/webm', 'video/ogg', 'video/quicktime'];
            if (!in_array($mimeType, $allowedMimes)) {
                return redirect()->back()
                    ->withErrors(['video_file' => 'El archivo debe ser un video (MP4, WebM u OGG). Tipo detectado: ' . $mimeType])
                    ->withInput();
            }
        }

        $this->videoService->update($video, $validated, $request->file('video_file'));

        return redirect()->back()
            ->with('success', 'Video actualizado exitosamente.');
    }

    public function destroy(Video $video)
    {
        Gate::authorize('delete', $video);

        $this->videoService->delete($video);

        return redirect()->back()
            ->with('success', 'Video eliminado exitosamente.');
    }
}

