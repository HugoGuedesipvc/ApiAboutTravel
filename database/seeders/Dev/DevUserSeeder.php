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
            ['name' => 'Leandro Santos', 'email' => 'geral@riftweb.com', 'username' => 'riftweb', 'password' => '123456789', 'phone_number' => '925432018', 'profile_picture' => 'https://www.riftweb.com/profile.jpg', 'description' => 'Web Developer'],
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
