<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'psikolog_id',
        'topic_id',
        'date',
        'type',
        'diagnosis',
        'status',
    ];
}
