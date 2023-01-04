<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'image',
        'description',
        'psikolog_id',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedules::class, 'topic_id');
    }
}
