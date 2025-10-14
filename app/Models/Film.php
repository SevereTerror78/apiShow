<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    public $timestamps = false; 

    protected $fillable = [
        'title', 
        'director_id',
        'release_date',
        'description',
        'image',
        'type_id',
        'length',
        'created_at',
        'updated_at'
    ];
}
