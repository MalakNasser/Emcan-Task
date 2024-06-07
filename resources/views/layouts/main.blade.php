<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 700;
        }

        .navbar-link {
            font-size: 20px;
            margin-right: 15px;
            text-decoration: none;
            color: black;
            transition: color 0.3s ease;
        }

        .navbar-link:hover {
            color: #007bff;
        }

        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    @section('navbar')
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                @if (Auth::check() && Auth::user()->role === 'user')
                    <a class="navbar-brand" href="{{ route('courses.index') }}">Home</a>
                @elseif(Auth::check() && Auth::user()->role === 'admin')
                    <a class="navbar-brand" href="{{ route('courses.index') }}">Dashboard</a>
                @endif

                <div class="navbar-nav">
                    <a class="navbar-link nav-item nav-link" href="{{ route('courses.index') }}">Courses</a>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <a class="navbar-link nav-item nav-link" href="{{ route('courses.create') }}">Add Course</a>
                    @endif
                    <a class="navbar-link nav-item nav-link" href="{{ route('enrollment.index') }}">Enrolled
                        Courses</a>
                </div>

                <div class="navbar-nav ml-auto">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-item nav-link">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    @show
    <div class="container">@yield('content')</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
