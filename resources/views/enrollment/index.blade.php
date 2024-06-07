@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4" style="font-size: 2.5rem; font-weight: bold;">Enrollments</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    @if (Auth::user()->role === 'admin')
                                        <th scope="col">User</th>
                                    @endif
                                    <th scope="col">Course Title</th>
                                    <th scope="col">Enrolled At</th>
                                    @if (Auth::user()->role === 'user')
                                        <th scope="col">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrollments as $enrollment)
                                    <tr>
                                        <th scope="row">{{ $enrollment->id }}</th>
                                        @if (Auth::user()->role === 'admin')
                                            <td>{{ $enrollment->user->name }}</td>
                                        @endif
                                        <td>{{ $enrollment->course->title }}</td>
                                        <td>{{ $enrollment->created_at }}</td>
                                        @if (Auth::user()->role === 'user')
                                            <td>
                                                <form method="POST"
                                                    action="{{ route('enrollment.destroy', $enrollment->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
