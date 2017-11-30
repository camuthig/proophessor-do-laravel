<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'proophessor-do-laravel!')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section('stylesheets')
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/bootstrap.slate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/bootstrap.datetimepicker.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    @show
</head>
<body>
<nav class="navbar navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('page::home') }}">proophessor-do-laravel</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">

            </ul>
        </div><!--/.nav-collapse  -->
    </div>
</nav>
<div class="row">
    <div class="hidden-xs col-sm-3 col-md-2">
        <div id="sidebar-left" data-spy="affix" data-offset-top="60">
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('page::home') }}">Welcome Screen</a>
                </li>
                <li>
                    <a href="{{ route('page::user-list') }}">Manage Users</a>
                </li>
                <li>
                    <a href="#/create">Manage Todos</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-sm-7 col-md-8">
        @yield('content')
        <hr>
        <footer>
            <p>&copy; 2014 - {{ "now"|date("Y") }} by prooph software GmbH. All rights reserved.</p>
        </footer>
    </div>
    <div class="col-sm-2 col-md-2">
        @isset($sidebar_right)
        {{ $sidebar_right }}
        @endisset
    </div>
</div>
    @section('javascripts')
        <script src="{{ asset('js/lodash.js') }}"></script>
        <script src="{{ asset('js/underscore.string.js') }}"></script>
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/notify.min.js') }}"></script>
        <script src="{{ asset('js/validate.min.js') }}"></script>
        <script src="{{ asset('js/jquery.plugins.js') }}"></script>
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
        <script src="{{ asset('js/uuid.js') }}"></script>
        <script src="{{ asset('js/riot.min.js') }}"></script>
        <script src="{{ asset('js/prooph.riot.app.js') }}"></script>
    @show
    @yield('page_js')
</body>
</html>
