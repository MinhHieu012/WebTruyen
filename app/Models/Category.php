<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['name', 'slug', 'desc'];

    public function stories() {
        return $this->belongsToMany(Story::class, 'categorie_storie', 'categorie_id', 'storie_id')->withTimestamps();
    }
}
