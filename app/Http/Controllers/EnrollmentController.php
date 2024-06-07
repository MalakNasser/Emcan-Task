<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'user') {
            $enrollments = Enrollment::where('user_id', $user->id)->get();
        } else {
            $enrollments = Enrollment::get();
        }
        return view('enrollment.index', ['enrollments' => $enrollments]);
    }

    public function create($courseId)
    {
        $user = Auth::user();

        if ($user && $user->role === 'user') {
            $existingEnrollment = Enrollment::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->first();

            if (!$existingEnrollment) {
                $enrollment = new Enrollment([
                    'user_id' => $user->id,
                    'course_id' => $courseId,
                ]);
                $enrollment->save();

                return redirect()->route('courses.index')->with('success', 'You have been enrolled in the course.');
            } else {
                return redirect()->route('courses.index')->with('error', 'You are already enrolled in this course.');
            }
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in as a user to enroll in a course.');
        }
    }


    public function destroy($enrollmentId)
    {
        $user = Auth::user();

        if ($user && $user->role === 'user') {
            $enrollment = Enrollment::find($enrollmentId);

            if ($enrollment && $enrollment->user_id === $user->id) {
                $courseId = $enrollment->course_id;
                $enrollment->delete();
                return redirect()->route('courses.index')->with('success', 'You have been unenrolled from the course.');
            } else {
                return redirect()->route('enrollment.index')->with('error', 'Enrollment not found or you are not authorized to unenroll.');
            }
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in as a user to unenroll from a course.');
        }
    }
}
