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
    Route::get('login', 'Auth\AuthController@showLoginForm')->name('authLoginPost');
    Route::post('login', 'Auth\AuthController@login')->name('authLogin');
    Route::get('logout', 'Auth\AuthController@logout')->name('authLogout');

    // Registration Routes...
    Route::get('register', 'Auth\AuthController@showRegistrationForm')->name('authRegisterForm');
    Route::post('register', 'Auth\AuthController@register')->name('authRegister');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm')->name('authResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail')->name('authSendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset')->name('authReset');

    // Home page Routes...
    Route::get('/home', 'HomeController@index')->name('indexHome');
    Route::get('/', 'HomeController@index')->name('index');

    // Test Attempts
    Route::get('/attempts', 'TestAttemptsController@index')->name('attemptsIndex');
    Route::get('/attempts/continue/{attempt_id}', 'TestAttemptsController@continueTest')->name('attemptsContinue');
    Route::get('/attempts/continue/{attempt_id}/{question_index}', 'TestAttemptsController@continueTest')->name('attemptsContinueWithSkip');
    Route::get('/attempts/create/{test_id}', 'TestAttemptsController@createAttempt')->name('attemptsCreate');
    Route::get('/attempts/result/{attempt_id}', 'TestAttemptsController@result')->name('attemptsResult');

    // Test
    Route::get('/test', 'TestController@listTests')->name('testIndex');
    Route::get('/test/create', 'TestController@showCreateForm')->name('testCreateForm');
    Route::get('/test/{stub}', 'TestController@stub')->where('stub', '[A-Za-z]+')->name('testViewStub');
    Route::get('/test/{test_id}', 'TestController@index')->name('testView');

    Route::post('/test/create', 'TestController@create')->name('testCreate');

    // Tests
    Route::get('/tests/add_question/{question_id}', 'TestController@showAddQuestionForm')->name('testsAddQuestionForm');
    Route::post('/tests/add_question/{question_id}', 'TestController@addQuestion')->name('testsAddQuestion');

    // Answers
    Route::post('answers/submit', 'AnswersController@submit')->name('answersSubmit');

    // Questions
    Route::get('/questions', 'QuestionsController@listAllQuestions')->name('questionsIndex');
    Route::get('/questions/submit', 'QuestionsController@showSubmitForm')->name('questionsSubmitForm');
    Route::get('/questions/search/', 'QuestionsController@search')->name('questionsSearch');
    Route::get('/questions/flag/{question_id}', 'QuestionsController@showFlagForm')->name('questionsFlagForm');
    Route::get('/questions/edit/{question_id}', 'QuestionsController@showEditForm')->name('questionsEditForm');
    Route::get('/questions/{question_id}', 'QuestionsController@viewQuestion')->name('questionsView');
    Route::get('/questions/{question_id}/comments', 'QuestionsController@viewQuestionComments')->name('questionsComments');

    Route::post('/questions/vote/{question_id}', 'VoteController@questionVote')->name('questionsVote');
    Route::post('/questions/flag/{question_id}', 'QuestionsController@flag')->name('questionsFlag');
    Route::post('/questions/submit', 'QuestionsController@submit')->name('questionsSubmit');
    Route::post('/questions/edit/{question_id}', 'QuestionsController@edit')->name('questionsEdit');

    // Profile
    Route::get('/profile/summary', 'ProfileController@summary')->name('profileSummary'); // TODO
    Route::get('/profile/attempts', 'TestAttemptsController@index')->name('profileAttempts');
    Route::get('/profile/answers', 'AnswersController@index')->name('profileAnswers');
    Route::get('/profile/questions', 'QuestionsController@myQuestions')->name('profileQuestions');
    Route::get('/profile/tests', 'TestController@myTests')->name('profileTests');

    // Categories
    Route::get('/categories/', 'CategoriesController@index')->name('categoriesIndex');
    Route::get('/categories/json', 'CategoriesController@json')->name('categoriesJson');
    Route::get('/categories/add/{category_id}', 'CategoriesController@showAddForm')->name('categoriesAdd');
    Route::get('/categories/{category_id}', 'CategoriesController@show')->name('categoriesView');
    Route::get('/categories/{category_id}/browse', 'QuestionsController@category')->name('categoriesBrowse');

    // Notifications
    Route::get('/notifications/generate', function(Faker\Generator $faker) {
        for($i = 0; $i < 20; $i++) {
            $notification = new \App\Notification();
            $notification->notification = $faker->sentence(10);
            $notification->read = false;
            $notification->user()->associate(Auth::user());
            $notification->save();
        }

        return Auth::user()->notifications()->get();
    });

    Route::post('/categories/add', 'CategoriesController@submit')->name('categoriesSubmit');

    Route::get('/debug', 'VoteController@dooo');

});
