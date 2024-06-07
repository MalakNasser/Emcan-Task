<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\Course;
use App\Models\User;

class CourseEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_enroll_in_course()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);
        $this->actingAs($user);

        $course = Course::factory()->create([
            'title' => 'Test Course',
            'description' => 'Test Course Description',
        ]);

        $response = $this->post(route('enrollment.create', $course));

        $response->assertRedirect(route('courses.index'));
        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }


    /** @test */
    public function unauthenticated_user_cannot_enroll_in_course()
    {
        $course = Course::factory()->create();

        $response = $this->post(route('enrollment.create', $course));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('enrollments', 0);
    }

    /** @test */
    public function admin_can_access_enrollment_index()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get(route('enrollment.index'));

        $response->assertStatus(200);
    }
}
