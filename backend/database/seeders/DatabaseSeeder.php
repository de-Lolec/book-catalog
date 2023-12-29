<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Author::factory(10)->create();
        // \App\Models\Book::factory(20)->create();
        // \App\Models\Category::factory(10)->create();
        // \App\Models\BookCategory::factory(10)->create();

        $user = [
          'name' => 'admin',
          'email' => 'admin@admin.admin',
          'is_admin' => true,
          'password' => Hash::make('password'),
      ];

      DB::table('users')->insert($user);
    }
}
