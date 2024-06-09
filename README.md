# Learning Management System

## Description

A Laravel-based web application focused on culinary education. It features user authentication, CRUD operations for courses and lessons, user enrollment in courses, role-based access control for admins and users, and a search functionality for finding courses by title or description. The frontend is designed using Blade templates to ensure a responsive and intuitive user experience."

## Table of Contents

- [Project Setup](#project-setup)
- [Database Schema](#database-schema)
- [Basic Functionality](#basic-functionality)
- [Additional Features](#additional-features)
- [Frontend](#frontend)
- [Testing](#testing)
- [Demo Video](#demo-video)

## Project Setup

1. Clone the repository.
2. Install dependencies:
   ```bash
   composer install
   ```
   ```bash
   npm install vite@latest
   ```
3. Copy `.env.example` to `.env` and configure your database settings.
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Migrate the database:
   ```bash
   php artisan migrate
   ```
6. Run the development server:
   ```bash
   php artisan serve
   ```

## Database Schema

- Users: Standard Laravel user model.
- Courses: `id`, `title`, `description`, timestamps.
- Lessons: `id`, `title`, `content`, `course_id`, timestamps.
- Enrollments: `id`, `user_id`, `course_id`, timestamps.

## Basic Functionality

- CRUD operations for Courses and Lessons.
- User enrollment in Courses.
- Displaying enrolled Courses and Lessons.

## Additional Features

- Role-based access control:
  - Admins can create, update, and delete Courses and Lessons.
  - Users can enroll in Courses.
- Search functionality to find Courses by title or description.

## Frontend

- UI using Blade templates.
- Responsive and user-friendly design.

## Testing

Run the following command to execute feature tests:
```bash
php vendor/phpunit/phpunit/phpunit tests/Feature
```

## Demo Video 

[![Demo](https://img.youtube.com/vi/M05SHzdtWUA/0.jpg)](https://www.youtube.com/watch?v=M05SHzdtWUA)
