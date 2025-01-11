<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    public function index(Request $request) {
        $validator = Validator::make($request->all(), [
            'icon' => 'required|string|max:20'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $opinions = Option::where('icon',  $request->query('icon'))->get();
        return response()->json(['message' => 'ok', 'data' => $opinions], 200);
    }

    public function create(Request $request) {

        // Check if the user is an admin (cosider implementing this based on your actual user roles)
        if (!Auth::user() || Auth::user()->role !== 'admin'){
            return response()->json(['error' => 'Unauthorized'], 403); // Forbidden
        }

        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:255',
            'icon' => 'required|string|in:check-mark,cross-mark'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $option = Option::create([
            'text' => $request->text,
            'icon' => $request->icon,
        ]);

        return response()->json(['message' => 'Course created successfully', 'option' => $option], 201);
    }
}
