<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Address::class,100)->create();
        factory(\App\User::class,50)->create();
        factory(\App\Product::class,150)->create();
        factory(\App\Image::class,350)->create();
        factory(\App\Review::class,350)->create();
        factory(\App\Category::class,5)->create();
        factory(\App\Tag::class,15)->create();
         factory(\App\Ticket::class ,15)->create();

    }
}
