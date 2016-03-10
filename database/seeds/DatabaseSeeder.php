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
        factory(App\User::class, 50)->create()->each(function (App\User $u) {
            $u->questions()->saveMany(factory(App\Question::class, 5)->create()->each(function (App\Question $q) use ($u) {
                $q->comments()->saveMany(factory(App\Comment::class, 5)->create([
                    'user_id'     => $u->id,
                    'question_id' => $q->id,
                ])->each(function (App\Comment $c) use ($u, $q) {
                    $c->votes()->saveMany(factory(App\CommentVotes::class, 5)->create([
                        'user_id'    => $u->id,
                        'comment_id' => $c->id,
                    ]));
                }));

                $q->votes()->saveMany(factory(App\QuestionVote::class, 5)->create([
                    'user_id'     => $u->id,
                    'question_id' => $q->id,
                ]));
            }));

            $u->tests()->saveMany(factory(App\Test::class, 5)->create()->each(function (App\Test $t) use ($u) {
                App\Question::all()->random(5)->each(function ($q) use ($u, $t) {
                    $t->questions()->attach($q);
                });
            }));

            $u->testAttempts()->saveMany(factory(App\TestAttempt::class, 5)->create([
                'test_id' => App\Test::all()->random()->id,
                'user_id' => $u->id,
            ])->each(function (App\TestAttempt $ta) use ($u) {
                $questions = App\Test::find(App\TestAttempt::find($ta->id)->id)->questions()->get()->random(5);
                while ($questions->count() != 0) {
                    $ta->answers()->save(factory(App\Answer::class)->make([
                        'question_id' => $questions->pop()->id,
                        'test_id'     => App\TestAttempt::find($ta->id)->test->id,
                        'user_id'     => $u->id,
                        'attempt_id'  => $ta->id,
                    ]));
                }
            }));

        });
    }
}
