<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const TYPE_DAY = 1;
    const TYPE_MONTH = 2;
    const TYPE_ALL_TIME = 3;

    protected $fillable = ['status', 'type', 'value'];
}
