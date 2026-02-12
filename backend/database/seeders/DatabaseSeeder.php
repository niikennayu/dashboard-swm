<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        //  Make example User (firstOrCreate)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password123') // password default
            ]
        );

        // Running Seeder Customer and Device
        $this->call([
            CustomerDeviceSeeder::class,
        ]);

        // $this->call(AnotherSeeder::class);
    }
}
