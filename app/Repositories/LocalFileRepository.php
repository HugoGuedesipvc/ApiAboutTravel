<?php

namespace App\Repositories;


use App\Models\Local;
use App\Models\LocalFile;
use Illuminate\Support\Collection;
use Throwable;

class LocalFileRepository
{
    public function all(): Collection
    {
        try {
            return LocalFile::all();
        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function find($id): ?LocalFile
    {
        try {
            return LocalFile::findOrFail($id);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function store(
        Local $local,
        string $label,
        string $path,
    ): ?LocalFile
    {
        try {
            $data = [
                "local_id" => $local->id,
                "name" => $label,
                "path" => $path,
            ];

            return LocalFile::create($data);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function update(
        LocalFile $file,
        string    $label,
        string    $path
    ): bool
    {
        try {
            $data = [
                "label" => $label,
                "path" => $path,
            ];

            return $file->update($data);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function delete(LocalFile $media): bool
    {
        try {
            return $media->delete();
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
