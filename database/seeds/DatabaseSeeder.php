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
                ])->each(function (App\Comment $c) use ($u, $q) {
                    $c->votes()->saveMany(factory(App\Vote::class, 5)->create());
                }));

                $q->votes()->saveMany(factory(App\Vote::class, 5)->create());
            }));

            $u->tests()->saveMany(factory(App\Test::class, 5)->create()->each(function (App\Test $t) use ($u) {
                $t->comments()->saveMany(factory(App\Comment::class, 5)->create([
                    'user_id' => $u->id,
                ]));

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

        $root = \App\Category::create(['name' => 'Root']);
        $root->makeRoot();

        factory(App\Category::class, 25)->create()->each(function (App\Category $c) use ($root) {
            $c->makeChildOf($root);
            $c->user()->associate(App\User::all()->random());
            $c->save();
        });

        factory(App\Category::class, 70)->create()->each(function (App\Category $c) {
            $c->makeChildOf(App\Category::where('depth', 1)->get()->random());
            $c->user()->associate(App\User::all()->random());
            $c->save();
        });

        factory(App\Category::class, 130)->create()->each(function (App\Category $c) {
            $c->makeChildOf(App\Category::where('depth', 2)->get()->random());
            $c->user()->associate(App\User::all()->random());
            $c->save();
        });

        App\Question::all()->each(function (App\Question $q) {
            $q->category()->associate(App\Category::all()->random());
            $q->save();
        });
    }
}
