<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plant;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plants = [
            [
                'name' => 'Rose',
                'description' => 'Beautiful flowering plant',
                'diseases' => 'Powdery mildew, black spot',
            ],
            [
                'name' => 'Tomato',
                'description' => 'Edible red fruiting plant',
                'diseases' => 'Early blight, late blight',
            ],
            [
                'name' => 'Lemon',
                'description' => 'Citrus fruit tree',
                'diseases' => 'Citrus canker, black sooty mold',
            ],
        ];

        foreach ($plants as $plant) {
            Plant::create($plant);
        }
    }
}
