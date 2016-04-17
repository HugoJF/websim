<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Test;
use App\TestAttempt;
use Auth;
use Redirect;
use View;


class TestAttemptsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $testAttempts = $user->testAttempts()->get();

        //return $testAttempts->first()->toJson();
        return View::make('attempts.list')->with(compact('testAttempts'));
    }

    public function continueTest($attempt_id = -1, $offsetAmount = 0)
    {
        $user = Auth::user();

        // Get the attempt with Test and Questions ORM Objects
        $attempt = $user->testAttempts()->with('test')->find($attempt_id);

        // Redirect to homepage if test is already completed
        if ($attempt->finished === true) {
            return Redirect::route('attemptsResult', ['attempt_id' => $attempt_id]);
        }

        // Test questions
        $testQuestions = $attempt->test->questions;


        // Get every answer for questions
        $attemptsAnsweredQuestions = Answer::where('attempt_id', $attempt->id)->get();


        // Remove question that have answers in the database
        $remainingQuestions = $testQuestions->reject(function ($question) use ($attemptsAnsweredQuestions) {
            return $attemptsAnsweredQuestions->contains(function ($key, $value) use ($question) {
                return $value->question_id == $question->id;
            });
        });

        // Debug remaining questions
        \Debugbar::info('There are '.$remainingQuestions->count().' questions remaining in this test attempt.');

        // If there are no questions remaining, close the attempt and redirect to homepage
        if ($remainingQuestions->count() === 0) {
            $attempt->finished = true;
            $attempt->save();

            return Redirect::route('attemptsResult', ['attempt_id' => $attempt_id]);
        }

        $questionIndex = $offsetAmount % ($remainingQuestions->count());

        \Debugbar::info('Accessing question at index '.$questionIndex.' in remaining questions collection.');

        // Get the question remaining in the test
        $question = $remainingQuestions[$remainingQuestions->keys()[$questionIndex]];

        $question->load('comments', 'comments.user');

        $skipQuestionPath = route('attemptsContinueWithSkip', ['attempt_id' => $attempt->id, 'question_index' => $questionIndex + 1]);

        return View::make('questions.view')->with(compact('attempt', 'question', 'skipQuestionPath'));
    }

    public function createAttempt($test_id = -1)
    {
        $user = Auth::user();

        // Get unfinished attempts for the test
        $attempts = $user->testAttempts()->unfinished()->where('test_id', $test_id)->orderBy('created_at', 'desc');

        // Create new attempt if there are not attempts in DB
        if ($attempts->count() == 0) {
            $attempt = new TestAttempt();

            $attempt->user_id = $user->id;
            $attempt->test_id = $test_id;
            $attempt->finished = false;

            $attempt->save();
        } elseif ($attempts->count() >= 2) {
            //Invalid amount of attempts
            return 'More than 1';
        }

        return Redirect::route('attemptsContinue', ['attempt_id' => $attempts->first()->id]);
    }

    public function result($attempt_id = -1)
    {
        $attempt = TestAttempt::with('answers', 'answers.question', 'answers.question.user')->find($attempt_id);

        return View::make('attempts.result')->with(compact('attempt'));
    }
}
