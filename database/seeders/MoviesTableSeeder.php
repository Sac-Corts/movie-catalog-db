<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Movie;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::truncate();

        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Movie::create([
                'title' => $faker->sentence,
                'synopsis' => $faker->paragraph,
                'year' => $faker->year,
                'cover' => $faker->imageUrl(640, 480, 'movies', true)
            ]);
        }
    }
}
