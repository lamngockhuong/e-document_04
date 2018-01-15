<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('123'),
        'remember_token' => str_random(10),
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'avatar' => '/images/photo.jpg',
        'free_download' => 3,
        'uploaded_count' => 0,
        'wallet' => 0,
        'status' => 0,
        'role' => serialize('member'),
    ];
});

$factory->define(\App\Models\Document::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle,
        'slug' => $faker->slug,
        'image' => 'images/photo.jpg',
        'description' => $faker->jobTitle,
        'content' => $faker->paragraph,
        'source' => 'http://localhost/file.docx',
        'file_type' => $faker->randomElement(['doc', 'docx', 'pdf', 'ppt', 'pptx', 'xsl', 'xsls']),
        'document_status' => $faker->randomElement([0, 1]),
        'comment_status' => $faker->randomElement([0, 1]),
        'coin' => $faker->numberBetween(0, 100),
        'page_count' => $faker->numberBetween(0, 50),
        'view_count' => $faker->numberBetween(0, 1000),
        'download_count' => $faker->numberBetween(0, 1000),
    ];
});

$factory->define(\App\Models\Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
        'parent' => 0,
        'status' => $faker->randomElement([0, 1]),
    ];
});

$factory->define(\App\Models\Activity::class, function (Faker $faker) {
    return [
        'action' => $faker->randomElement(['upload', 'download']),
        'target_type' => 'Document',
    ];
});


$factory->define(\App\Models\Option::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'value' => $faker->text,
    ];
});

$factory->define(\App\Models\Transaction::class, function (Faker $faker) {
    return [
        'coin_count' => $faker->numberBetween(0, 100000),
        'type' => $faker->randomKey(['buy', 'bonus']),
        'status' => $faker->randomElement([0, 1, 2, 3]),
    ];
});

$factory->define(\App\Models\Term::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->slug,
    ];
});

$factory->define(\App\Models\TermTaxonomy::class, function (Faker $faker) {
    return [
        'taxonomy' => $faker->randomElement(['tag', 'category']),
        'description' => $faker->paragraph,
    ];
});

$factory->define(\App\Models\Friend::class, function (Faker $faker) {
    return [
        'status' => $faker->randomElement([0, 1]),
        'created_at' => $faker->dateTime(),
    ];
});

$factory->define(\App\Models\Message::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
    ];
});

