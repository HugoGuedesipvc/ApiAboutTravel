<?php

namespace App\Services;


use App\Models\Country;
use App\Repositories\CountryRepository;
use Illuminate\Support\Collection;

class CountryService
{
    public function __construct(
        protected CountryRepository $countryRepository
    )
    {
    }

    public function all(): Collection
    {
        return $this->countryRepository
            ->all();
    }

    public function findByIso2(string $iso2): ?Country
    {
        return $this->countryRepository
            ->findByIso2($iso2);
    }

    public function find($id): ?Country
    {
        return $this->countryRepository
            ->find($id);
    }

    public function store(): ?Country
    {
        return $this->countryRepository
            ->store();
    }

    public function update(Country $country): bool
    {
        return $this->countryRepository
            ->update(
                $country
            );
    }

    public function delete(Country $country): bool
    {
        return $this->countryRepository
            ->delete(
                $country
            );
    }
}
