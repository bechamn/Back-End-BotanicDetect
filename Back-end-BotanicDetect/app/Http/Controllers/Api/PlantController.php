<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlantController extends Controller
{
    public function index()
    {
        $plants = Plant::all();
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
