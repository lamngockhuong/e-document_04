<?php

use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documents = \App\Models\Document::all();

        App\Models\User::all()->each(function ($user) use ($documents) {
            $user->favorites()->attach(
                $documents->random(rand(1, 3))->pluck('id')->toArray(),
                ['created_at' => \Carbon\Carbon::now()]
            );
        });
    }
}
