<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlantDisease;

class PlantDiseaseList extends Controller
{
    public function index()
    {
        $diseases = PlantDisease::all();

        return response()->json($diseases);
    }
}