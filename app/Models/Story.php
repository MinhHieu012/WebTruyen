<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Story extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const FULL = 1;
    const IS_NEW = 1;
    const IS_HOT = 1;

    protected $fillable = [
        'slug',
        'image',
        'name',
        'desc',
        'author_id',
        'status',
        'is_full',
        'is_new',
        'is_hot'
    ];

    protected $table = 'stories';

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categorie_storie', 'storie_id', 'categorie_id')->withTimestamps();
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'story_id', 'id');
    }

    public function getLatestChapter()
    {
        return $this->chapters()->select('id', 'chapter', 'name')->orderBy('id', 'desc')->first();
    }

    public function star() {
        return $this->hasOne(Star::class, 'story_id', 'id');
    }

}
