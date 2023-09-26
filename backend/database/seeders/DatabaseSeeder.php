<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Moritz',
             'email' => 'admin@der-taenzer.net',
             'password' => '$2y$10$bYhzpsczfNrhE6/Pt7pdKOnyLF6e15WAmXSkPIlYOJ3P7bdw/YO3u'
         ]);

         $e = new \App\Models\Event();
         $e->name = "Halloweenparty";
         $e->date = "2023-10-30";
         $e->time = "20:00";
         $e->user_id = 1;
         $e->save();
         
    }
}