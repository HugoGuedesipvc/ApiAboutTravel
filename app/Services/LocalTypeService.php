<?php

namespace App\Service;


use App\Models\LocalType;
use App\Repositories\LocalTypeRepository;
use Illuminate\Support\Collection;
use Throwable;

class LocalTypeService
{
    public function __construct(
        protected LocalTypeRepository $localTypeRepository
    )
    {
    }

    public function all(): Collection
    {
        return $this->localTypeRepository
            ->all();
    }

    public function find($id): ?LocalType
    {
        return $this->localTypeRepository
            ->find($id);
    }

    public function store(): ?LocalType
    {
        return $this->localTypeRepository
            ->store();
    }

    public function update(
        LocalType $localType,
        string $name,
        string $description
    ): bool
    {
        return $this->localTypeRepository
            ->update(
                $localType,
                $name,
                $description
            );
    }

    public function delete(LocalType $localType): bool
    {
        return $this->localTypeRepository
            ->delete(
                $localType
            );
    }
}
