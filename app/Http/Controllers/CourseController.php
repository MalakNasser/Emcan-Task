<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Lesson;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->query('search');
        $courses = Course::where(function ($query) use ($search) {
            $query->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        })->paginate(10);
        return view('courses.index', ['courses' => $courses, 'search' => $search]);
    }


    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lessons.*.title' => 'required|string|max:255',
            'lessons.*.content' => 'nullable|string',
        ]);

        $course = Course::create($request->only(['title', 'description']));

        if ($request->has('lessons')) {
            foreach ($request->lessons as $lesson) {
                $course->lessons()->create($lesson);
            }
        }

        return redirect()->route('courses.index');
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.show',  ['course' => $course]);
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', ['course' => $course]);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lessons.*.id' => 'nullable|exists:lessons,id',
            'lessons.*.title' => 'required|string|max:255',
            'lessons.*.content' => 'nullable|string',
            'new_lessons.*.title' => 'required|string|max:255',
            'new_lessons.*.content' => 'nullable|string',
            'deleted_lessons' => 'nullable|array',
            'deleted_lessons.*' => 'exists:lessons,id',
        ]);

        $course = Course::findOrFail($id);
        $course->update($request->only(['title', 'description']));

        if ($request->has('lessons')) {
            foreach ($request->lessons as $lessonData) {
                if (isset($lessonData['id'])) {
                    $lesson = Lesson::findOrFail($lessonData['id']);
                    $lesson->update($lessonData);
                }
            }
        }

        if ($request->has('new_lessons')) {
            foreach ($request->new_lessons as $newLessonData) {
                $course->lessons()->create($newLessonData);
            }
        }

        if ($request->has('deleted_lessons')) {
            foreach ($request->deleted_lessons as $deletedLessonId) {
                Lesson::destroy($deletedLessonId);
            }
        }

        return redirect()->route('courses.index');
    }


    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
