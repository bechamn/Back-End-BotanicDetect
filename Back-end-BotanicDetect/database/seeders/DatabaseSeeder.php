<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\PlantDisease;
use App\Models\Plant;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $diseases = [
        //     ['name' => 'Tomato Leaf Mold', 'treatment' => 'Remove infected leaves, apply fungicide.'],
        //     ['name' => 'Tomato healthy', 'treatment' => 'No treatment required.'],
        //     ['name' => 'Apple Cedar apple rust', 'treatment' => 'Prune affected branches, apply fungicide.'],
        //     ['name' => 'Apple healthy', 'treatment' => 'No treatment required.'],
        //     ['name' => 'Grape healthy', 'treatment' => 'No treatment required.'],
        //     ['name' => 'Grape Black rot', 'treatment' => 'Remove infected grapes, apply fungicide.'],
        //     ['name' => 'Strawberry healthy', 'treatment' => 'No treatment required.'],
        //     ['name' => 'Strawberry Leaf scorch', 'treatment' => 'Remove infected leaves, apply fungicide.'],
        //     ['name' => 'Potato healthy', 'treatment' => 'No treatment required.'],
        //     ['name' => 'Potato Late blight', 'treatment' => 'Remove infected leaves, apply fungicide.'],
        // ];

        // read cure.json and make seeder based on key as name and value as treatment
        $file = File::get(database_path('seeders/cure.json'));
        $diseases = json_decode($file, true);

        foreach ($diseases as $name => $treatment) {
            PlantDisease::create([
                'name' => $name,
                'treatment' => $treatment,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
