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
        string $name,
        string $description
    ): ?LocalType
    {
        try {
            $data = [
                "name" => $name,
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
        string $name,
        string $description
    ): bool
    {
        try {
            $data = [
                "name" => $name,
                "description" => $description
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
