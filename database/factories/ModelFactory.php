<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/**
 * Defines App\User factory.
 */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    $created_at = $faker->dateTimeThisMonth()->format('Y-m-d H:i:s');

    return [
        'name'           => $faker->name,
        'email'          => $faker->email,
        'type'           => $faker->randomElement(['admin', 'user']),
        'password'       => bcrypt('password'),
        'remember_token' => str_random(10),
        'created_at'     => $created_at,
        'updated_at'     => $created_at,
    ];
});

/*
 * Defines App\Test factory
 */
$factory->define(App\Test::class, function (Faker\Generator $faker) {
    $created_at = $faker->dateTimeThisMonth()->format('Y-m-d H:i:s');
    $unlisted = $faker->boolean(10);

    //Check if we need to create users
    if (App\User::all()->count() == 0) {
        echo 'Users table is empty, generating users';
        factory(App\User::class, 10)->create();
    }

    return [
        'name'       => $faker->sentence(15),
        'user_id'    => App\User::all()->random()->id,
        'created_at' => $created_at,
        'updated_at' => $created_at,
        'unlisted'   => $unlisted,
        'stub'       => $unlisted ? $faker->regexify('^[a-zA-Z]{25}$') : null,
    ];
});

/*
 * App\Question factory
 */
$factory->define(App\Question::class, function (Faker\Generator $faker) {
    $questionTitle = $faker->sentence(15);
    $possibleAnswers = $faker->sentences(5);
    $question = [
        'possibleAnswers' => $possibleAnswers,
        'correctAnswer'   => $faker->numberBetween(0, 4),
    ];

    //JSON Encode data
    $questionJson = json_encode($question);

    //Check if we need to create users
    if (App\User::all()->count() == 0) {
        echo 'Users table is empty, generating users';
        factory(App\User::class, 10)->create();
    }

    return [
        'user_id'        => App\User::all()->random()->id,
        'question_title' => $questionTitle,
        'information'    => $questionJson,
    ];
});

/*
 * App\Vote
 */
$factory->define(App\Vote::class, function (Faker\Generator $faker) {
   return [
        'direction' => $faker->boolean(70),
   ];
});

/*
 * App\Answer
 */
$factory->define(App\Answer::class, function (Faker\Generator $faker) {
    return [
        'answer' => $faker->numberBetween(0, 4),
    ];
});

/*
 * App\TestAttempt factory
 */
$factory->define(App\TestAttempt::class, function (Faker\Generator $faker) {
    return [
        'finished' => false,
    ];
});

/*
 * App\Comment factory
 */
$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'comment' => $faker->sentence(15),
    ];
});

/*
 * App\Category factory
 */

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    $created_at = $faker->dateTimeThisMonth()->format('Y-m-d H:i:s');

    return [
        'name'       => $faker->sentence,
        'created_at' => $created_at,
        'updated_at' => $created_at,
    ];
});

/*
 * App\Report factory
 */
$factory->define(App\Report::class, function (Faker\Generator $faker) {
    return [
        'reason'  => $faker->text(100),
        'details' => $faker->paragraphs(2, true),
    ];
});
