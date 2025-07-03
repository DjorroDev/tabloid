<?php

namespace App\Http\Controllers;

use App\Models\TabloidImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TabloidImageController extends Controller
{
    public function index()
    {
        // Return a list of images (dummy response)
        $images = TabloidImage::all()->map(function ($image) {
            $image->path = asset($image->path);
            return $image;
        });
        return response()->json(['images' => $images]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $image = $request->file('image');
            $path = $image->store('tabloid', 'public');

            TabloidImage::create(['path' => 'storage/' . $path]);
            return response()->json(['message' => 'Image uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e]);
        }
    }

    public function destroy($id)
    {
        $image = TabloidImage::find($id);

        if (!$image) {
            return response()->json(['message' => "Image with id $id not found"], 404);
        }

        // Delete the file from storage
        $filePath = public_path($image->path);
        if (file_exists($filePath)) {
            // @unlink($filePath);
            Storage::disk('public')->delete(str_replace('storage/', '', $image->path));
        }

        // Delete the database record
        $image->delete();

        return response()->json(['message' => "Image with id $id deleted successfully"]);
    }
}
