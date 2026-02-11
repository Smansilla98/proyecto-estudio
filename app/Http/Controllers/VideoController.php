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

        $validated = $request->validate([
            'tambor_id' => ['required', 'exists:tambores,id'],
            'url_video' => ['nullable', 'url'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,webm,ogg', 'max:102400'],
            'orden_ejecucion' => ['required', 'integer', 'min:0'],
        ]);

        $validated['ritmo_id'] = $ritmo->id;

        if ($request->hasFile('video_file')) {
            $this->videoService->create($validated, $request->file('video_file'));
        } else {
            if (empty($validated['url_video'])) {
                return redirect()->back()
                    ->with('error', 'Debes proporcionar una URL o subir un archivo de video.');
            }
            $this->videoService->create($validated);
        }

        return redirect()->back()
            ->with('success', 'Video agregado exitosamente.');
    }

    public function update(Request $request, Video $video)
    {
        Gate::authorize('update', $video);

        $validated = $request->validate([
            'tambor_id' => ['required', 'exists:tambores,id'],
            'url_video' => ['nullable', 'url'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,webm,ogg', 'max:102400'],
            'orden_ejecucion' => ['required', 'integer', 'min:0'],
        ]);

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

