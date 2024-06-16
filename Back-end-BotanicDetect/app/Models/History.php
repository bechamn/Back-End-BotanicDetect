<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';
    protected $primaryKey = 'id';

    protected $fillable = [
        "disease_id",
        "image_path",
        "user_id",
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function diseases()
    {
        return $this->belongsTo(PlantDisease::class, 'disease_id');
    }
}
