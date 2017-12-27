<?php

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Message::class, 1)->create(['sender_id' => '1', 'receiver_id' => '2']);
        factory(Message::class, 1)->create(['sender_id' => '2', 'receiver_id' => '3']);
        factory(Message::class, 1)->create(['sender_id' => '3', 'receiver_id' => '4']);
    }
}
