<?php

namespace App\Services;


use App\Models\Local;
use App\Models\Media;
use App\Repositories\MediaRepository;
use Illuminate\Support\Collection;
use Throwable;

class MediaService
{
    public function __construct(
        protected MediaRepository $mediaRepository
    )
    {
    }

    public function all(): Collection
    {
        return $this->mediaRepository
            ->all();
    }

    public function find($id): ?Media
    {
        return $this->mediaRepository
            ->find($id);
    }

    public function store(
        Local $local,
        string $name,
        string $path
    ): ?Media
    {
        return $this->mediaRepository
            ->store(
                $local,
                $name,
                $path
            );
    }

    public function update(
        Media $media,
        Local $local,
        string $name,
        string $path
    ): bool
    {
        return $this->mediaRepository
            ->update(
                $media,
                $local,
                $name,
                $path,
            );
    }

    public function delete(Media $media): bool
    {
        return $this->mediaRepository
            ->delete(
                $media
            );
    }
}
