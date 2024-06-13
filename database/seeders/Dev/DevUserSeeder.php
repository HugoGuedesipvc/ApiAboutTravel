<?php

namespace Database\Seeders\Dev;

use App\Services\UserService;
use Illuminate\Database\Seeder;

class DevUserSeeder extends Seeder
{
    public function __construct(protected UserService $userService)
    {
    }

    public function run(): void
    {
        $data = [
            ['name' => 'Hugo Guedes', 'email' => 'hugo.guedes@riftweb.com', 'username' => 'Jhon', 'password' => '123456789', 'phone_number' => '999999999', 'profile_picture' => 'test', 'description' => 'hhhhh'],
            ['name' => 'TestName 1', 'email' => 'hugo.guedes@riftweb.com', 'username' => 'Jhon2', 'password' => '123456789', 'phone_number' => '999999999', 'profile_picture' => 'test', 'description' => 'hhhhh'],
            ['name' => 'TestName 2', 'email' => 'hugo.guedes@riftweb.com', 'username' => 'Jhon3', 'password' => '123456789', 'phone_number' => '999999999', 'profile_picture' => 'test', 'description' => 'hhhhh']
        ];

        foreach ($data as $item) {
            $this->userService
                ->store(
                    $item['name'],
                    $item['email'],
                    $item['username'],
                    $item['password'],
                    $item['phone_number'],
                    $item['profile_picture'],
                    $item['description'],
                );
        }
    }
}
