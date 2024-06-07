@extends('layouts.main')

@section('title', 'Edit Course')

@section('content')
    <div class="container mt-5">
        <h1>Edit {{ $course->title }} Course</h1>
        <form method="POST" action="{{ route('courses.update', $course->id) }}" enctype="multipart/form-data"
            class="my-4 p-4 border rounded">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $course->title) }}" required>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                    rows="5" required>{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <h2>Edit Lessons</h2>
            <div id="existing-lessons">
                @if ($course->lessons->isEmpty())
                    <p>There is no lessons, You can add Now</p>
                @else
                    @foreach ($course->lessons as $lesson)
                        <div class="lesson">
                            <input type="hidden" name="lessons[{{ $lesson->id }}][id]" value="{{ $lesson->id }}">
                            <div class="form-group">
                                <label for="lessons[{{ $lesson->id }}][title]">Lesson Title</label>
                                <input type="text" name="lessons[{{ $lesson->id }}][title]" class="form-control"
                                    value="{{ old('lessons.' . $lesson->id . '.title', $lesson->title) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="lessons[{{ $lesson->id }}][content]">Lesson Content</label>
                                <textarea name="lessons[{{ $lesson->id }}][content]" class="form-control">{{ old('lessons.' . $lesson->id . '.content', $lesson->content) }}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-danger delete-lesson btn-sm"
                                    onclick="deleteLesson(this, {{ $lesson->id }})">Delete Lesson</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <h2>Add New Lessons</h2>
            <div id="new-lessons">
            </div>

            <div class="form-group mt-3">
                <button type="button" id="addLesson" class="btn btn-secondary btn-sm">Add Lesson</button>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary btn-sm">Update</button>
            </div>
            <div id="deleted-lessons-container" style="display: none;"></div>
        </form>
    </div>

    <script>
        function deleteLesson(element, lessonId) {
            element.closest('.lesson').remove();

            if (lessonId) {
                const deletedLessonInput = document.createElement('input');
                deletedLessonInput.type = 'hidden';
                deletedLessonInput.name = `deleted_lessons[${lessonId}]`;
                deletedLessonInput.value = lessonId;

                const deletedLessonsContainer = document.getElementById('deleted-lessons-container');
                deletedLessonsContainer.appendChild(deletedLessonInput);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-lesson').forEach(function(button) {
                button.addEventListener('click', function() {
                    const lessonId = this.dataset.lessonId;
                    deleteLesson(this, lessonId);
                });
            });

            document.getElementById('addLesson').addEventListener('click', function() {
                const newLessonIndex = document.querySelectorAll('.lesson').length + 1;
                const newLessonHtml = `
                    <div class="lesson">
                        <div class="form-group">
                            <label for="new_lessons[${newLessonIndex}][title]">New Lesson Title</label>
                            <input type="text" name="new_lessons[${newLessonIndex}][title]"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="new_lessons[${newLessonIndex}][content]">New Lesson Content</label>
                            <textarea name="new_lessons[${newLessonIndex}][content]"
                                class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-danger delete-lesson btn-sm">Delete Lesson</button>
                        </div>
                    </div>
                `;
                document.getElementById('new-lessons').insertAdjacentHTML('beforeend', newLessonHtml);

                const newLesson = document.querySelector(`#new-lessons .lesson:last-child .delete-lesson`);
                newLesson.addEventListener('click', function() {
                    deleteLesson(this);
                });
            });
        });
    </script>
@endsection
