<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Course;

class LessonController extends Controller
{
    public function index($course_id)
    {
        $course = Course::findOrFail($course_id);
        $lessons = $course->lessons;
        return view('lessons.index', ['course' => $course, 'lessons' => $lessons]);
    }

    public function create($course_id)
    {
        $course = Course::findOrFail($course_id);
        return view('lessons.create', ['course' => $course]);
    }

    public function store(Request $request, $course_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $course = Course::findOrFail($course_id);
        $course->lessons()->create($request->all());

        return redirect()->route('courses.show', $course_id);
    }

    public function show($course_id, $lesson_id)
    {
        $course = Course::findOrFail($course_id);
        $lesson = Lesson::findOrFail($lesson_id);
        return view('lessons.show', ['course' => $course, 'lesson' => $lesson]);
    }

    public function edit($course_id, $lesson_id)
    {
        $course = Course::findOrFail($course_id);
        $lesson = Lesson::findOrFail($lesson_id);
        return view('lessons.edit', ['course' => $course, 'lesson' => $lesson]);
    }

    public function update(Request $request, $course_id, $lesson_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $lesson = Lesson::findOrFail($lesson_id);
        $lesson->update($request->only(['title', 'content']));

        return redirect()->route('courses.show', $course_id);
    }

    public function destroy($course_id, $lesson_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        $lesson->delete();

        return redirect()->route('courses.show', $course_id);
    }
}
