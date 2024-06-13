<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PlantDisease;
use Illuminate\Support\Str;
// use App\Http\Controllers\Api\analyze_image;


class PlantDiseaseController extends Controller
{
    /**
     * Handle leaf scan and disease detection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function scanLeaf(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'leaf_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Handle the image upload
        $imagePath = $request->file('leaf_image')->store('uploads', 'public');

        // Call your TensorFlow Lite model to process the image
        $detectedDisease = $this->analyzeImage($imagePath);
        // return $detectedDisease;

        if ($detectedDisease) {
            // Check if the detected disease exists in the database
            $disease = PlantDisease::where('slug', Str::slug($detectedDisease))->first();

            if ($disease) {
                // If disease exists, return JSON response with disease details
                return response()->json([
                    'success' => true,
                    'message' => 'Disease detected successfully.',
                    'disease' => $disease
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Detected disease not found in the database.'
                ], 404);
            }
        } else {
            // If detection fails, return JSON response with error message
            return response()->json([
                'success' => false,
                'message' => 'Failed to process the image. Please try again.'
            ], 500);
        }
    }

    /**
     * Function to analyze the image and detect disease.
     *
     * @param string $imagePath
     * @return string|null Detected disease name or null if detection fails
     */
    private function analyzeImage($imagePath)
    {
        // Replace this with your actual detection logic
        // Example: Assuming you have a DiseaseDetector service
        $pythonScriptPath = base_path('app/Http/Controllers/Api/analyze_image.py'); // Path to your script
        $imageFullPath = storage_path('app/public/' . $imagePath);

        $escScriptPath = escapeshellarg($pythonScriptPath);
        $escImageFullPath = escapeshellarg($imageFullPath);

        // $command = escapeshellcmd("py $pythonScriptPath $imageFullPath");
        $output = shell_exec("python {$escScriptPath} {$escImageFullPath}");

        $result = json_decode($output, true);

        if (json_last_error() === JSON_ERROR_NONE && isset($result['predicted_class'])) {
            return $result['predicted_class'];
        }

        return null;
    }
}
