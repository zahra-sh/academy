<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $fileName = $user->id . '.' . $request->image->extension();

            // Store the image in the public directory under 'images/users/'
            $path = $request->file('image')->storeAs('images/users', $fileName, 'public');

            $user->image = $path;
            $user->save();

            return response()->json(['message' => 'Image uploaded successfully', 'path' => $path], 201);
        }

        return response()->json(['error' => 'Image not found'], 404);
    }

    public function getAttendees(Request $request){
        $usersQuery = User::query();

        $role = $request->query('role') ? $request->query('role') : 'ordinary';
        $usersQuery->where('role', $role);

        $users = $usersQuery->select('id', 'name', 'family', 'image')->paginate(5);

        $users->getCollection()->transform(function ($user) {
            $user->image = url('storage/' . $user->image); // Construct the full URL for the image
            return $user;
        });
        return response()->json($users, 200);
    }

    public function index(Request $request) {
        $usersQuery = User::query();

        // Filter by role if the role query parameter is provided
        $role = $request->query('role') ? $request->query('role') : 'ordinary';
        $usersQuery->where('role', $role);

        $users = $usersQuery->select('id', 'name', 'family', 'email', 'mobile')->paginate(3);//, 'image'

        $users->getCollection()->transform(function ($user) {
            $user->image = url('storage/' . $user->image); // Construct the full URL for the image
            return $user;
        });
        return response()->json($users, 200);
    }
}
