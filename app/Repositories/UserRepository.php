<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
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
        string  $name,
        string  $email,
        string  $username,
        string  $password,
        ?string $phoneNumber,
        ?string $profilePicture,
        ?string $description,
    ): ?User
    {
        try {
            $data = [
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => $password,
                'phone_number' => $phoneNumber,
                'profile_picture' => $profilePicture,
                'description' => $description,
            ];

            return User::create($data);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function update(
        User    $user,
        ?string $name,
        ?string $email,
        ?string $username,
        ?string $password,
        ?string $phoneNumber,
        ?string $profilePicture,
        ?string $description
    ): bool
    {
        try {
            $data = [
                'name' => $name ?? $user->name,
                'email' => $email ?? $user->email,
                'username' => $username ?? $user->username,
                'phone_number' => $phoneNumber ?? $user->phone_number,
                'profile_picture' => $profilePicture ?? $user->profile_picture,
                'description' => $description ?? $user->description,
            ];

            if ($password !== null) {
                $data['password'] = Hash::make($password);
            }
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
