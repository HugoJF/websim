<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('indexHome') }}">Home</a></li>
                    <li><a href="{{ route('categoriesIndex') }}">Category list</a></li>
                    <li><a href="{{ route('testIndex') }}">Tests</a></li>
                    <li><a href="{{ route('testCreateForm') }}">Create test</a></li>
                    <li><a href="{{ route('questionsIndex') }}">Questions</a></li>
                    <li><a href="{{ route('questionsSubmitForm') }}">Create question</a></li>
                    <li><a href="{{ route('questionsSearch') }}">Question search</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('authLogin') }}">Login</a></li>
                        <li><a href="{{ route('authRegister') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('profileSummary') }}"><i class="fa fa-btn fa-list"></i>Summary</a></li>
                                <li><a href="{{ route('profileAttempts') }}"><i class="fa fa-btn fa-tasks"></i>My Attempts</a></li>
                                <li><a href="{{ route('profileAnswers') }}"><i class="fa fa-btn fa-check-square"></i>My Answers</a></li>
                                <li><a href="{{ route('profileQuestions') }}"><i class="fa fa-btn fa-pencil"></i>My Questions</a></li>
                                <li><a href="{{ route('profileTests') }}"><i class="fa fa-btn fa-file-text-o "></i>My Tests</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('authLogout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="{{ asset('jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap.min.js') }}"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
