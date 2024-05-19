<?php

namespace App\Services;


use App\Models\Local;
use App\Models\LocalFile;
use App\Repositories\LocalFileRepository;
use Illuminate\Support\Collection;
use Throwable;

class LocalFileService
{
    public function __construct(
        protected LocalFileRepository $localFileRepository
    )
    {
    }

    public function all(): Collection
    {
        return $this->localFileRepository
            ->all();
    }

    public function find($id): ?LocalFile
    {
        return $this->localFileRepository
            ->find($id);
    }

    public function store(
        Local $local,
        string $label,
        string $path
    ): ?LocalFile
    {
        return $this->localFileRepository
            ->store(
                $local,
                $label,
                $path
            );
    }

    public function update(
        LocalFile $file,
        string    $label,
        string    $path
    ): bool
    {
        return $this->localFileRepository
            ->update(
                $file,
                $label,
                $path,
            );
    }

    public function delete(LocalFile $media): bool
    {
        return $this->localFileRepository
            ->delete(
                $media
            );
    }
}
