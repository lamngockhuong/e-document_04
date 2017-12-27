<?php

use App\Models\Friend;
use Illuminate\Database\Seeder;

class FriendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Friend::class, 1)->create(['sender_id' => '1', 'recipent_id' => '2']);
        factory(Friend::class, 1)->create(['sender_id' => '2', 'recipent_id' => '3']);
        factory(Friend::class, 1)->create(['sender_id' => '3', 'recipent_id' => '4']);
    }
}
