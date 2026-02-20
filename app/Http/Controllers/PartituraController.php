<?php

namespace App\Http\Controllers;

use App\Models\Ritmo;
use App\Models\Partitura;
use App\Services\PartituraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PartituraController extends Controller
{
    public function __construct(
        private PartituraService $partituraService
    ) {}

    public function store(Request $request, Ritmo $ritmo)
    {
        Gate::authorize('create', Partitura::class);

        // Verificar que el archivo esté presente en la solicitud
        if (!$request->hasFile('archivo_pdf')) {
            return redirect()->back()
                ->withErrors(['archivo_pdf' => 'Debe seleccionar un archivo PDF para subir.'])
                ->withInput();
        }

        // Validar el archivo con mensajes personalizados
        $validated = $request->validate([
            'archivo_pdf' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240', // 10MB en kilobytes
            ],
        ], [
            'archivo_pdf.required' => 'Debe seleccionar un archivo PDF.',
            'archivo_pdf.file' => 'El archivo debe ser un archivo válido.',
            'archivo_pdf.mimes' => 'El archivo debe ser un PDF (formato .pdf).',
            'archivo_pdf.max' => 'El archivo no debe ser mayor a 10MB. Verifique la configuración de PHP (upload_max_filesize y post_max_size).',
        ]);

        // Obtener el archivo
        $archivo = $request->file('archivo_pdf');
        
        // Verificar que el archivo existe y es válido
        if (!$archivo) {
            return redirect()->back()
                ->withErrors(['archivo_pdf' => 'No se pudo obtener el archivo. Verifique que el formulario tenga enctype="multipart/form-data".'])
                ->withInput();
        }

        if (!$archivo->isValid()) {
            $errorCode = $archivo->getError();
            $errorMessage = match($errorCode) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'El archivo es demasiado grande. El tamaño máximo permitido es 10MB.',
                UPLOAD_ERR_PARTIAL => 'El archivo se subió parcialmente. Intente nuevamente.',
                UPLOAD_ERR_NO_FILE => 'No se seleccionó ningún archivo.',
                UPLOAD_ERR_NO_TMP_DIR => 'Error del servidor: falta el directorio temporal.',
                UPLOAD_ERR_CANT_WRITE => 'Error del servidor: no se pudo escribir el archivo.',
                UPLOAD_ERR_EXTENSION => 'Error del servidor: una extensión de PHP detuvo la subida del archivo.',
                default => 'El archivo no es válido o no se pudo subir. Código de error: ' . $errorCode,
            };
            
            return redirect()->back()
                ->withErrors(['archivo_pdf' => $errorMessage])
                ->withInput();
        }

        // Verificar el tipo MIME del archivo
        $mimeType = $archivo->getMimeType();
        if ($mimeType !== 'application/pdf') {
            return redirect()->back()
                ->withErrors(['archivo_pdf' => 'El archivo debe ser un PDF. Tipo detectado: ' . $mimeType])
                ->withInput();
        }

        // Preparar datos sin el archivo (el servicio lo manejará por separado)
        $data = [
            'ritmo_id' => $ritmo->id,
        ];

        $this->partituraService->create($data, $archivo);

        return redirect()->back()
            ->with('success', 'Partitura agregada exitosamente.');
    }

    public function update(Request $request, Partitura $partitura)
    {
        Gate::authorize('update', $partitura);

        // Validar el archivo con mensajes personalizados
        $validated = $request->validate([
            'archivo_pdf' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:10240', // 10MB en kilobytes
            ],
        ], [
            'archivo_pdf.file' => 'El archivo debe ser un archivo válido.',
            'archivo_pdf.mimes' => 'El archivo debe ser un PDF (formato .pdf).',
            'archivo_pdf.max' => 'El archivo no debe ser mayor a 10MB.',
        ]);

        // Obtener el archivo si existe
        $archivo = $request->file('archivo_pdf');
        
        // Si hay archivo, verificar que es válido
        if ($archivo) {
            if (!$archivo->isValid()) {
                $errorCode = $archivo->getError();
                $errorMessage = match($errorCode) {
                    UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'El archivo es demasiado grande. El tamaño máximo permitido es 10MB.',
                    UPLOAD_ERR_PARTIAL => 'El archivo se subió parcialmente. Intente nuevamente.',
                    UPLOAD_ERR_NO_FILE => 'No se seleccionó ningún archivo.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Error del servidor: falta el directorio temporal.',
                    UPLOAD_ERR_CANT_WRITE => 'Error del servidor: no se pudo escribir el archivo.',
                    UPLOAD_ERR_EXTENSION => 'Error del servidor: una extensión de PHP detuvo la subida del archivo.',
                    default => 'El archivo no es válido o no se pudo subir. Código de error: ' . $errorCode,
                };
                
                return redirect()->back()
                    ->withErrors(['archivo_pdf' => $errorMessage])
                    ->withInput();
            }

            // Verificar el tipo MIME del archivo
            $mimeType = $archivo->getMimeType();
            if ($mimeType !== 'application/pdf') {
                return redirect()->back()
                    ->withErrors(['archivo_pdf' => 'El archivo debe ser un PDF. Tipo detectado: ' . $mimeType])
                    ->withInput();
            }
        }
        
        // Preparar datos sin el archivo
        $data = [];

        $this->partituraService->update($partitura, $data, $archivo);

        return redirect()->back()
            ->with('success', 'Partitura actualizada exitosamente.');
    }

    public function show(Partitura $partitura)
    {
        Gate::authorize('view', $partitura);

        $partitura->load(['ritmo.tambores']);
        $partituraUrl = $this->partituraService->getUrl($partitura);

        return view('partituras.show', compact('partitura', 'partituraUrl'));
    }

    public function destroy(Partitura $partitura)
    {
        Gate::authorize('delete', $partitura);

        $this->partituraService->delete($partitura);

        return redirect()->back()
            ->with('success', 'Partitura eliminada exitosamente.');
    }
}
