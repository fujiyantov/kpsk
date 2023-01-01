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
        'time',
        'type',
        'diagnosis',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function psikolog()
    {
        return $this->belongsTo(User::class, 'psikolog_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topics::class, 'topic_id');
    }
}
