<?php

namespace App\Repositories;


use App\Models\Local;
use App\Models\Media;
use Illuminate\Support\Collection;
use Throwable;

class MediaRepository
{
    public function all(): Collection
    {
        try {
            return Media::all();
        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function find($id): ?Media
    {
        try {
            return Media::findOrFail($id);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function store(
        Local $local,
        string $name,
        string $path,
    ): ?Media
    {
        try {
            $data = [
                "local_id" => $local->id,
                "name" => $name,
                "path" => $path,
            ];

            return Media::create($data);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function update(
        Media $media,
        Local $local,
        string $name,
        string $path
    ): bool
    {
        try {
            $data = [
                "local_id" => $local->id,
                "name" => $name,
                "path" => $path,
            ];

            return $media->update($data);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function delete(Media $media): bool
    {
        try {
            return $media->delete();
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
