<?php

namespace App\Repositories;


use App\Models\LocalType;
use Illuminate\Support\Collection;
use Throwable;

class LocalTypeRepository
{
    public function all(): Collection
    {
        try {
            return LocalType::all();
        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function find($id): ?LocalType
    {
        try {
            return LocalType::findOrFail($id);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function store(
        string $label,
        ?string $description
    ): ?LocalType
    {
        try {
            $data = [
                "label" => $label,
                "description" => $description
            ];

            return LocalType::create($data);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function update(
        LocalType $localType,
        string $label,
        ?string $description
    ): bool
    {
        try {
            $data = [
                "label" => $label,
                "description" => $description ?? $localType->description
            ];

            return $localType->update($data);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function delete(LocalType $localType): bool
    {
        try {
            return $localType->delete();
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
