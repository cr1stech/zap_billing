<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientAccount;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SuperAdminSeeder::class,
        ]);

        Client::factory()
            ->count(3)
            ->has(ClientAccount::factory()->count(9), 'accounts')
            ->create();
    }
}
