<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => 'Juan Dela Cruz',
            'position' => 'Kagawad',
            'email' => 'juan.delacruz@example.com',
        ]);

        Author::factory()->count(4)->create();
    }
}
