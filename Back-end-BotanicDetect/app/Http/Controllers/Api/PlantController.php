<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PlantController extends Controller
{
    public function index()
    {
        // Get the current authenticated user's ID
        $userId = Auth::id();
    
        // Retrieve plants based on the user_id
        $plants = Plant::where('user_id', $userId)->get();
    
        // Return the plants as JSON response
        return response()->json($plants);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'diseases' => 'nullable|string',
            'plantimages' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $imagesplant = null;
        if ($request->hasFile('plantimages')) {
            $image = $request->file('plantimages');
            $imagesplant = time() . '.' . $image->extension();
            $image->move(public_path('Plan Images'), $imagesplant);
        }
    
        $plant = Plant::create([
            'name' => $request->name,
            'description' => $request->description,
            'diseases' => $request->diseases,
            'plantimages' => $imagesplant,
            'user_id' => Auth::user()->id
        ]);
    
        return response()->json($plant, 201);
    }
    
    

    public function update(Request $request, $id)
    {
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'diseases' => 'nullable|string',
            'plantimages' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Find the plant by ID
        $plant = Plant::findOrFail($id);

        // Check if the authenticated user owns the plant
        if (Auth::id() !== $plant->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Handle image upload
        if ($request->hasFile('plantimages')) {
            // Delete the old image if it exists
            if ($plant->plantimages) {
                $oldImagePath = public_path('Plan Images/' . $plant->plantimages);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload the new image
            $image = $request->file('plantimages');
            $imagesplant = time() . '.' . $image->extension();
            $image->move(public_path('Plan Images'), $imagesplant);
            $plant->plantimages = $imagesplant;
        }

        // Update plant information
        $plant->name = $request->name;
        $plant->description = $request->description;
        $plant->diseases = $request->diseases;

        // Save the updated plant
        $plant->save();

        // Return a JSON response
        return response()->json($plant, 200);
    }
    
    
        
    public function show(Plant $plant)
    {
        return response()->json($plant);
    }
}
