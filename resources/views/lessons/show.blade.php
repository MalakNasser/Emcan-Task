@extends('layouts.main')

@section('title', 'Lesson Details')

@section('content')

    <div class="lesson-details">
        <h1>{{ $lesson->title }} Lesson Details</h1>
        <p><strong>ID:</strong> {{ $lesson->id }}</p>
        <p><strong>Title:</strong> {{ $lesson->title }}</p>
        <p><strong>Content:</strong> {{ $lesson->content }}</p>
        <p><strong>Added At:</strong> {{ $lesson->created_at }}</p>
    </div>
@endsection
