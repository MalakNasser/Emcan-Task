@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4" style="font-size: 2.5rem; font-weight: bold;">Courses</h1>
        <div class="row mb-4 justify-content-center">
            <form action="{{ route('courses.index') }}" method="GET" class="form-inline">
                <input type="text" name="search" class="form-control mr-2" placeholder="Search by title or description"
                    value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-primary">Search</button>
                @if ($search)
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary ml-2">Clear</a>
                @endif
            </form>
        </div>
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm" style="border-radius: 10px;">
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 1.5rem; font-weight: bold;">{{ $course->title }}</h5>
                            <p class="card-text" style="font-size: 1rem; color: #555;">
                                {{ Str::limit($course->description, 100) }}</p>
                            <h6 style="font-size: 1.2rem; font-weight: bold;">Lessons:</h6>
                            @if ($course->lessons->isEmpty())
                                <p style="font-size: 1rem; color: #888;">No lessons</p>
                            @else
                                <ul class="list-unstyled">
                                    @foreach ($course->lessons as $lesson)
                                        <li style="font-size: 1rem;">{{ $lesson->title }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="actions">
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info btn-sm">View</a>
                                @if (Auth::check() && Auth::user()->role === 'user')
                                    <form id="enroll-form-{{ $course->id }}"
                                        action="{{ route('enrollment.create', $course->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm enroll-btn">Enroll</button>
                                    </form>
                                @elseif(Auth::check() && Auth::user()->role === 'admin')
                                    <a href="{{ route('courses.edit', $course->id) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                timer: 3000
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 3000
            });
        </script>
    @endif
@endsection
