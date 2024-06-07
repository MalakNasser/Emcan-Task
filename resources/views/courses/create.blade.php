@extends('layouts.main')

@section('title', 'Add Course')

@section('content')
    <div class="container mt-5">
        <h1>Add new Course</h1>
        <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data"
            class="my-4 p-4 border rounded">
            @csrf

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                    required value="{{ old('title') }}">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                    rows="5">{{ old('description') }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div id="lessons" class="mt-4">
                <h2>Lessons</h2>
            </div>

            <div class="form-group mt-3">
                <button type="button" id="addLesson" class="btn btn-info btn-sm">Add new Lesson</button>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary btn-sm">Create</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lessonsDiv = document.getElementById('lessons');

            document.getElementById('addLesson').addEventListener('click', function() {
                const lessonCount = lessonsDiv.getElementsByClassName('lesson').length;
                const newLessonDiv = document.createElement('div');
                newLessonDiv.classList.add('lesson');
                newLessonDiv.innerHTML = `
                    <div class="form-group">
                        <label for="lessons[${lessonCount}][title]">Lesson Title</label>
                        <input type="text" name="lessons[${lessonCount}][title]" class="form-control @error('lessons[${lessonCount}][title]') is-invalid @enderror" required>
                        @error('lessons[${lessonCount}][title]')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="lessons[${lessonCount}][content]">Lesson Content</label>
                        <textarea name="lessons[${lessonCount}][content]" class="form-control @error('lessons[${lessonCount}][content]') is-invalid @enderror"></textarea>
                        @error('lessons[${lessonCount}][content]')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="button" class="btn btn-danger delete-lesson-btn btn-sm">Delete Lesson</button>
                `;
                lessonsDiv.appendChild(newLessonDiv);

                newLessonDiv.querySelector('.delete-lesson-btn').addEventListener('click', function() {
                    newLessonDiv.remove();
                });
            });
        });
    </script>
@endsection
