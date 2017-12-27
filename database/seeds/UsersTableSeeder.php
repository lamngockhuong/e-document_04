<?php

use App\Models\Comment;
use App\Models\Document;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 30)->create()->each(function ($user) {
            $range = rand(2, 5);

            // Save many transactions for user
            $user->transactions()->saveMany(factory(Transaction::class, $range)->make());

            $user->documents()->saveMany(factory(Document::class, $range)->make());

            $user->comments()->saveMany(factory(Comment::class, $range)->make(['user_id' => $user->id, 'document_id' => rand(1, 10)]));

            $user->activities()->saveMany(factory(\App\Models\Activity::class, $range)->make(['user_id' => $user->id, 'target_id' => rand(1, 10)]));
        });
    }
}
