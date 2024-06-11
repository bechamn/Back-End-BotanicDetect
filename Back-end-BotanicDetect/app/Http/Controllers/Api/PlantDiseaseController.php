<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlantDiseaseController extends Controller
{
    public function processScan(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'leaf_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Handle the image upload
        $imagePath = $request->file('leaf_image')->store('uploads', 'public');

        // Call your TensorFlow Lite model to process the image
        $result = $this->analyzeImage($imagePath);

        // Return the result as a JSON response
        return response()->json($result);
    }

    private function analyzeImage($imagePath)
    {
        $pythonScriptPath = base_path('scripts/analyze_image.py'); // Path to your script
        $imageFullPath = storage_path('app/public/' . $imagePath);

        $command = escapeshellcmd("python3 $pythonScriptPath $imageFullPath");
        $output = shell_exec($command);

        $result = json_decode($output, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $result;
        }

        return [
            'error' => 'Failed to process the image',
        ];
    }
}
