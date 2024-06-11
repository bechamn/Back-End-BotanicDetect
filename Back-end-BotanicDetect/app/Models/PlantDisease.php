<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantDisease extends Model
{
    use HasFactory;

    protected $table = 'plant_disease'; // Specify the table name

    protected $fillable = ['name', 'treatment'];
}