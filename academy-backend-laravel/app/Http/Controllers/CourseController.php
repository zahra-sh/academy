<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{

    public function create(Request $request) {

        // Check if the user is an admin (consider implementing this based on your actual user roles)
        if (!Auth::user() || Auth::user()->role !== 'admin'){
            return response()->json(['error' => 'Unauthorized'], 403); // Forbidden
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $course = Course::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Course created successfully', 'course' => $course], 201);
    }

    public function index(Request $request) {
        $today = now();
        $coursesQuery = Course::query();

        if ($request->query('status')) {
//            $coursesQuery->where('start_date', '>', $today);
            $coursesQuery->where('status',  $request->query('status'));
        }

        $courses = $coursesQuery->with('teacher')->paginate(10);
        return response()->json($courses, 200);
    }

}
