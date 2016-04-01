<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {

    // Authentication Routes...
    Route::get('login', 'Auth\AuthController@showLoginForm');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');

    // Registration Routes...
    Route::get('register', 'Auth\AuthController@showRegistrationForm');
    Route::post('register', 'Auth\AuthController@register');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    // Home page Routes...
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index');

    // Test Attempts
    Route::get('/attempts', 'TestAttemptsController@index');
    Route::get('/attempts/continue/{attempt_id}', 'TestAttemptsController@continueTest');
    Route::get('/attempts/continue/{attempt_id}/{question_index}', 'TestAttemptsController@continueTest');
    Route::get('/attempts/create/{test_id}', 'TestAttemptsController@createAttempt');
    Route::get('/attempts/result/{attempt_id}', 'TestAttemptsController@result');

    // Test
    Route::get('/test', 'TestController@listTests');
    Route::get('/test/create', 'TestController@showCreateForm'); // TODO - Hard
    Route::get('/test/{stub}', 'TestController@stub')->where('stub', '[A-Za-z]+');
    Route::get('/test/{test_id}', 'TestController@index');

    Route::post('/test/create', 'TestController@create');

    // Tests
    Route::get('/tests/add_question/{question_id}', 'TestController@showAddQuestionForm');
    Route::post('/tests/add_question/{question_id}', 'TestController@addQuestion');

    // Answers
    Route::post('answers/submit', 'AnswersController@submit');

    // Questions
    Route::get('/questions', 'QuestionsController@listAllQuestions');
    Route::get('/questions/submit', 'QuestionsController@showSubmitForm');
    Route::get('/questions/search/', 'QuestionsController@search');
    Route::get('/questions/flag/{question_id}', 'QuestionsController@showFlagForm');
    Route::get('/questions/{question_id}', 'QuestionsController@viewQuestion');
    Route::get('/questions/{question_id}/comments', 'QuestionsController@viewQuestionComments');

    Route::post('/questions/flag', 'QuestionsController@flag');
    Route::post('/questions/submit', 'QuestionsController@submit');

    // Question votes
    Route::post('/question_vote/', 'QuestionVoteController@vote');

    // Profile
    Route::get('/profile/summary', 'ProfileController@summary'); // TODO
    Route::get('/profile/attempts', 'TestAttemptsController@index');
    Route::get('/profile/answers', 'AnswersController@index');
    Route::get('/profile/questions', 'QuestionsController@myQuestions');
    Route::get('/profile/tests', 'TestController@myTests');

    // Categories
    Route::get('/categories/', 'CategoriesController@index');
    Route::get('/categories/json', 'CategoriesController@json');
    Route::get('/categories/add/{category_id}', 'CategoriesController@showAddForm');
    Route::get('/categories/{category_id}', 'CategoriesController@show');
    Route::get('/categories/{category_id}/browse', 'QuestionsController@category');

    Route::post('/categories/add', 'CategoriesController@submit');

    //DEBUGGING
    Route::get('/do', function () {
        return \App\Question::find(1)->category()->associate(\App\Category::find(1));
    });

    //Version
    Route::get('/debug', function () {
        return phpinfo();
    });
});
