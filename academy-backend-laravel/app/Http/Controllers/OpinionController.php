<?php

namespace App\Http\Controllers;

use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Opinion;

class OpinionController extends Controller
{
    public function create(Request $request) {

        // Check if the user is an admin (consider implementing this based on your actual user roles)
        if (!Auth::user() ){
            return response()->json(['error' => 'Login first'], 403); // Forbidden
        }

        $request->validate([
            'text' => 'required|string|max:500',
            'vote' => 'required|integer|min:1|max:5',
        ]);

        $opinion = new Opinion();
        $opinion->text = $request->input('text');
        $opinion->vote = $request->input('vote');
        $opinion->user_id = Auth::id(); // Associate the opinion with the authenticated user
        $opinion->save();

        return response()->json(['message' => 'Opinion created successfully', 'opinion' => $opinion], 201);
    }

    public function index(Request $request) {
        $request->validate([
            'num' => 'integer',
        ]);

        $opinionQuery = Opinion::query();
        $num = $request->get('num') ? (int)$request->get('num') : 10;
        $opinions = $opinionQuery->with('user')->paginate($num);

        $opinions->getCollection()->transform(function ($opinion) {
            $opinion->user->image = url('storage/' . $opinion->user->image);
            return $opinion;
        });

        return response()->json($opinions, 200);
    }
}
