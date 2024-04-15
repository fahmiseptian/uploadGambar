<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class MediaController extends Controller
{
    public function detail($id)
    {
        return response()->json(['message' => User::findOrFail($id)], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Validate the provided name for the image
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image file
        ]);

        // Get the file from the request
        $file = $request->file('file');

        // Create a new Media instance
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        $user->addMediaFromBase64(base64_encode(Image::make($request->file('file'))->orientate()->encode('jpg', 90)->encoded))
            ->usingFileName(time() . '.jpg')
            ->toMediaCollection('artwork', 'public');

        return response()->json(['message' => 'Media uploaded successfully', 'user' => $user], 200);
    }
}
