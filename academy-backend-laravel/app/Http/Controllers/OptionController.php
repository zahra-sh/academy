<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class OptionController extends Controller
{
    public function index(Request $request) {
        $validator = Validator::make($request->all(), [
            'icon' => 'string|max:20',
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $opinionsQuery = Option::query();

        if ($request->query('icon')) {
            $opinionsQuery->where('icon',  $request->query('icon'));
        }
        if ($request->has('active') ){
            $opinionsQuery->where('active',  $request->query('active'));
        }

        $opinions = $opinionsQuery->paginate(3);//->get();

        return response()->json($opinions, 200);
    }

    public function create(Request $request) {

        // Check if the user is an admin (cosider implementing this based on your actual user roles)
//        if (!Auth::user() || Auth::user()->role !== 'admin'){
//            return response()->json(['error' => 'Unauthorized'], 403); // Forbidden
//        }

        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:255',
            'icon' => 'required|string|in:check-mark,cross-mark',
            'active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $option = Option::create([
            'text' => $request->text,
            'icon' => $request->icon,
            'active'  => $request->has('active') ? $request->input('active') : 'true',
        ]);

        return response()->json(['message' => 'Course created successfully', 'option' => $option], 201);
    }

    public function updateActiveStatus(Request $request, $id)
    {
//        if (!Auth::user() || Auth::user()->role !== 'admin'){
//            return response()->json(['error' => 'Unauthorized'], 403);
//        }

//        $request->validate([
//            'active' => 'required|boolean',
//        ]);

        $option = Option::find($id);

        if (!$option) {
            return response()->json(['message' => 'Option not found'], Response::HTTP_NOT_FOUND);
        }

        $option->active = $request->input('active') ? $request->input('active') : !$option->active;
        $option->save();

        return response()->json(['message' => 'Option updated successfully', 'option' => $option]);
    }

    public function updateText(Request $request, $id)
    {

//        if (!Auth::user() || Auth::user()->role !== 'admin'){
//            return response()->json(['error' => 'Unauthorized'], 403);
//        }

        $validator = $request->validate([
            'text' => 'required|string|max:255'
        ]);

        $option = Option::find($id);

        if (!$option) {
            return response()->json(['message' => 'Option not found'], Response::HTTP_NOT_FOUND);
        }

        $option->text = $request->input('text');
        $option->save();

        return response()->json(['message' => 'Option updated successfully', 'option' => $option]);
    }

    public function destroy($id)
    {
        try {
            $option = Option::findOrFail($id);

            $option->delete();

            return response()->json(['message' => 'Option deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting option: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to delete option.'], 500);
        }
    }
}
