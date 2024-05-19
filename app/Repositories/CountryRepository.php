<?php

namespace App\Repositories;


use App\Models\Country;
use Illuminate\Support\Collection;
use Throwable;

class CountryRepository
{
    public function all(): Collection
    {
        try {
            return Country::all();
        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function findByIso2(string $iso2): ?Country
    {
        try {
            return Country::where('iso_3166_2', $iso2)->first();
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function find($id): ?Country
    {
        try {
            return Country::findOrFail($id);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function store(): ?Country
    {
        try {
            $data = [];

            return Country::create($data);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function update(Country $country): bool
    {
        try {
            $data = [];

            return $country->update($data);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function delete(Country $country): bool
    {
        try {
            return $country->delete();
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
