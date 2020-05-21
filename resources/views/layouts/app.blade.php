<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $page_title ?? 'Productivity Dashboard' }}</title>

    <!-- Scripts -->
    {{--    <script src="{{ asset('js/app.js') }}"></script>--}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/07049bce1e.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}"/>
    @stack('style')

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        @auth
            <div class="position-absolute">
                <button type="button" id="sidebarCollapse" class="btn btn-outline-primary"><i class="fas fa-list"></i>
                </button>
            </div>
        @endauth
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Definitely not Trello
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item mr-2">

                        </li>
                        <li class="nav-item">
                            <div class="dropdown">
                                <button class="btn btn-primary " type="button" id="dropdownMenu2" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->username }} <i class="fas fa-chevron-circle-down ml-2"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <a href="{{ route('user.profile') }}" class="dropdown-item"
                                       type="button">Profile</a>
                                    <a href="{{ route('user.inbox') }}" class="dropdown-item">
                                        Messages <span id="mail_count" class="badge badge-{{Auth::user()->inbox_count() > 0 ? 'danger' : 'success'}}">{{ Auth::user()->inbox_count() }}</span>
                                    </a>
                                    <a href="{{ route('logout') }}" class="dropdown-item" type="button">Logout</a>
                                </div>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper">
        @auth
            <nav id="sidebar">
                <!-- Sidebar Header -->
                <div class="sidebar-header">
                    <h3>Welcome, {{ \Illuminate\Support\Facades\Auth::user()->username }}</h3>
                </div>

                <!-- Sidebar Links -->
                <ul class="list-unstyled components">
                    <li class="{{ ($active_page ?? '') == 'home' ? 'active' : '' }}"><a href="{{ route('main') }}">Home</a></li>
                    <li class="{{ ($active_page ?? '') == 'project' ? 'active' : '' }}">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Projects</a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="{{ route('project.create') }}">New</a></li>
                            <li><a href="{{ route('project') }}">See all</a></li>
                        </ul>
                    <li class="{{ ($active_page ?? '') == 'calendar' ? 'active' : '' }}"><a href="#">Calendar</a></li>
                    <li class="{{ ($active_page ?? '') == 'task' ? 'active' : '' }}"><a href="#">Tasks</a></li>
                    <li class="{{ ($active_page ?? '') == 'contact' ? 'active' : '' }}"><a href="#">Contacts</a></li>
                </ul>
            </nav>
        @endauth

        <div id="content" class="container mt-md-3">
            <div>
                @yield('content')
            </div>
        </div>
    </div>
</div>
@auth
    <script src="{{ asset('js/sidebar.js') }}"></script>
@endauth
@stack('scripts')
</body>
</html>
