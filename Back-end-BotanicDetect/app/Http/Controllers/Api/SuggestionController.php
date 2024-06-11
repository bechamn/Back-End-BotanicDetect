<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlantDisease;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    /**
     * Show all diseases with their treatments.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Fetch all diseases with their treatments
        $diseases = PlantDisease::all();

        return response()->json([
            'success' => true,
            'diseases' => $diseases,
            'message' => 'List of diseases fetched successfully.'
        ]);
    }

    /**
     * Show the suggestion page for the specific disease.
     *
     * @param  string  $diseaseSlug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($diseaseSlug)
    {
        // Fetch disease information from the database
        $disease = PlantDisease::where('slug', $diseaseSlug)->first();

        if ($disease) {
            return response()->json([
                'success' => true,
                'disease' => $disease,
                'message' => 'Disease details fetched successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Disease not found.'
            ], 404);
        }
    }
}
