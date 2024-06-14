<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\PlantDisease;
use App\Models\Plant;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $diseases = [
            ['name' => 'Tomato Leaf Mold', 'treatment' => 'Remove infected leaves, apply fungicide.'],
            ['name' => 'Tomato healthy', 'treatment' => 'No treatment required.'],
            ['name' => 'Apple Cedar apple rust', 'treatment' => 'Prune affected branches, apply fungicide.'],
            ['name' => 'Apple healthy', 'treatment' => 'No treatment required.'],
            ['name' => 'Grape healthy', 'treatment' => 'No treatment required.'],
            ['name' => 'Grape Black rot', 'treatment' => 'Remove infected grapes, apply fungicide.'],
            ['name' => 'Strawberry healthy', 'treatment' => 'No treatment required.'],
            ['name' => 'Strawberry Leaf scorch', 'treatment' => 'Remove infected leaves, apply fungicide.'],
            ['name' => 'Potato healthy', 'treatment' => 'No treatment required.'],
            ['name' => 'Potato Late blight', 'treatment' => 'Remove infected leaves, apply fungicide.'],
        ];

        foreach ($diseases as $disease) {
            PlantDisease::create([
                'name' => $disease['name'],
                'treatment' => $disease['treatment'],
                'slug' => Str::slug($disease['name']),
            ]);
        }
    }
}
