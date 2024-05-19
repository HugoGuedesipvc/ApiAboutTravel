<?php

namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    )
    {
    }

    public function all(): Collection
    {
        return $this->userRepository->all();
    }

    public function find($id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function store(
        string  $name,
        string  $email,
        string  $username,
        string  $password,
        ?string $phoneNumber,
        ?string $profilePicture,
        ?string $description,
    ): ?User
    {
        return $this->userRepository
            ->store(
                $name,
                $email,
                $username,
                $password,
                $phoneNumber,
                $profilePicture,
                $description,
            );
    }

    public function update(
        User    $user,
        string  $name,
        string  $email,
        string  $username,
        string  $password,
        ?string $phone_number,
        ?string $profile_picture,
        ?string $description,
    ): bool
    {
        return $this->userRepository
            ->update(
                $user,
                $name,
                $email,
                $username,
                $password,
                $phone_number,
                $profile_picture,
                $description,
            );
    }

    public function delete(User $user): bool
    {
        return $this->userRepository
            ->delete(
                $user
            );
    }
}
