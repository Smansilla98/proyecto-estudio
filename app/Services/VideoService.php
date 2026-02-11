<?php

namespace App\Services;

use App\Models\Video;
use App\Repositories\VideoRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VideoService
{
    public function __construct(
        private VideoRepository $videoRepository
    ) {}

    public function create(array $data, ?UploadedFile $file = null): Video
    {
        if ($file) {
            $disk = config('filesystems.default', 'local');
            $path = $file->store('videos', $disk);
            $data['url_video'] = $path;
        } elseif (empty($data['url_video'])) {
            throw new \InvalidArgumentException('Debe proporcionar una URL o un archivo de video.');
        }

        return $this->videoRepository->create($data);
    }

    public function update(Video $video, array $data, ?UploadedFile $file = null): Video
    {
        if ($file) {
            $disk = config('filesystems.default', 'local');
            
            // Eliminar video anterior si existe y no es URL externa
            if ($video->url_video && !filter_var($video->url_video, FILTER_VALIDATE_URL)) {
                if (Storage::disk($disk)->exists($video->url_video)) {
                    Storage::disk($disk)->delete($video->url_video);
                }
            }

            $path = $file->store('videos', $disk);
            $data['url_video'] = $path;
        }

        $this->videoRepository->update($video, $data);
        return $video->fresh(['ritmo', 'tambor']);
    }

    public function delete(Video $video): bool
    {
        // Solo eliminar si no es una URL externa
        if ($video->url_video && !filter_var($video->url_video, FILTER_VALIDATE_URL)) {
            $disk = config('filesystems.default', 'local');
            if (Storage::disk($disk)->exists($video->url_video)) {
                Storage::disk($disk)->delete($video->url_video);
            }
        }

        return $this->videoRepository->delete($video);
    }

    public function getUrl(Video $video): string
    {
        if (filter_var($video->url_video, FILTER_VALIDATE_URL)) {
            return $video->url_video;
        }

        $disk = config('filesystems.default', 'local');
        return Storage::disk($disk)->url($video->url_video);
    }
}

