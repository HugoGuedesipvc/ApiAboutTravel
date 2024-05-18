<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Collection;
use Throwable;

class UserRepository
{
    public function all(): Collection
    {
        try {
            return User::all();
        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function find($id): ?User
    {
        try {
            return User::findOrFail($id);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function store(
        string $name,
        string $email,
        string $username,
        string $password,
        ?string $phone_number,
        ?string $profile_picture,
        ?string $description,
    ): ?User
    {
        try {
            $data = [
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => $password,
                'phone_number' => $phone_number,
                'profile_picture' => $profile_picture,
                'description' => $description,
            ];

            return User::create($data);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function update(
        User $user,
        string $name,
        string $email,
        string $username,
        string $password,
        ?string $phone_number,
        ?string $profile_picture,
        ?string $description
    ): bool
    {
        try {
            $data = [
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => $password,
                'phone_number' => $phone_number,
                'profile_picture' => $profile_picture,
                'description' => $description,
            ];

            return $user->update($data);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function delete(User $user): bool
    {
        try {
            return $user->delete();
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
