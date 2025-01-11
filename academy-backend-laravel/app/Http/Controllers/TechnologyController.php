<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TechnologyController extends Controller
{
    public function create(Request $request) {

        // Check if the user is an admin (cosider implementing this based on your actual user roles)
        if (!Auth::user() || Auth::user()->role !== 'admin'){
            return response()->json(['error' => 'Unauthorized'], 403); // Forbidden
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image')) {
            $imagePath = $this->saveUploadedImage($request->file('image'),  $request->title);
            $technology = Technology::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
                'date' => $request->date,
            ]);

            return response()->json(['message' => 'Course created successfully', 'option' => $technology], 201);
        }else{
            return response()->json(['error' => 'The image field is required.'], 422);
        }
    }

    protected function saveUploadedImage($imageFile, $title)
    {
        $path = 'images/technologies';

        $imageName = $title . '-' . time() . '.' . $imageFile->getClientOriginalExtension();
        $imageFile->storeAs($path, $imageName, 'public');

        return $path . '/' . $imageName;
    }

    public function index(Request $request) {

        $request->validate([
            'num' => 'integer',
        ]);

        $technologyQuery = Technology::query();
        $num = $request->get('num') ? (int)$request->get('num') : 10;
        $technologies = $technologyQuery->paginate($num);

        $technologies->getCollection()->transform(function ($technology) {
            $technology->image = url('storage/' . $technology->image);
            return $technology;
        });

        return response()->json($technologies, 200);
    }
}
