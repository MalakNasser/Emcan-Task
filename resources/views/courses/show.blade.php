@extends('layouts.main')

@section('title', 'Course Details')

@section('content')

    <div class="course-details">
        <h1>{{ $course->title }} Course Details</h1>
        <p><strong>ID:</strong> {{ $course->id }}</p>
        <p><strong>Title:</strong> {{ $course->title }}</p>
        <p><strong>Description:</strong> {{ $course->description }}</p>
        <p><strong>Lessons:</strong></p>
        @if ($course->lessons->isEmpty())
            <p>No lessons</p>
        @else
            <ul>
                @foreach ($course->lessons as $lesson)
                    <li><a
                            href="{{ route('lessons.show', ['course' => $course->id, 'lesson' => $lesson->id]) }}">{{ $lesson->title }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
        <p><strong>Added At:</strong> {{ $course->created_at }}</p>
    </div>
@endsection
