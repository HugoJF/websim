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

/*Route::get('/', function () {
    return view('welcome');
});*/

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
    Route::get('/attempts/result/{attempt_id}', 'TestAttemptsController@result'); // TODO

    // Test
    Route::get('/test', 'TestController@listTests');
    Route::get('/test/create', 'TestController@create'); // TODO
    Route::get('/test/{test_id}', 'TestController@index');

    // Answers
    Route::post('answers/submit', 'AnswersController@submit');

    // Questions
    Route::get('/questions', 'QuestionsController@listQuestions');
    Route::get('/questions/submit', 'QuestionsController@submit'); // TODO
    Route::get('/questions/{question_id}', 'QuestionsController@viewQuestion');

    // Profile
    Route::get('/profile/attempts', 'TestAttemptsController@index'); // TODO
    Route::get('/profile/answers', 'ProfileController@answers'); // TODO Fix: point to correct controller, ProfileController shouldn't handle Answers/Questions/Test
    Route::get('/profile/questions', 'ProfileController@questions');
    Route::get('/profile/tests', 'ProfileController@tests');

    // Categories
    Route::get('/categories/', 'CategoriesController@index');
    Route::get('/categories/json', 'CategoriesController@json');
    Route::get('/categories/add/{category_id}', 'CategoriesController@showAddForm');
    Route::get('/categories/{category_id}', 'CategoriesController@show');

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
