<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            OptionsTableSeeder::class,
            TermsTableSeeder::class,
            UsersTableSeeder::class,
            TermTaxonomyDocumentsTableSeeder::class,
            FavoritesTableSeeder::class,
            FriendsTableSeeder::class,
            MessagesTableSeeder::class,
        ]);
    }
}
