<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;
use Setting;

class ProfileController extends Controller
{
    public function summary()
    {
        dd(Setting::all());
        return 'This should be a summary';
    }

    public function settings()
    {
        return view('settings.index');
    }

    public function settingsSubmit()
    {
        Setting::set('filter_answered_questions', Input::has('filter_answered_questions'));
        Setting::set('filter_answered_tests', Input::has('filter_answered_tests'));

        Setting::save();

        \Session::flash('success', 'Configuration saved!');

        return redirect()->route('profileSettings');
    }
}
