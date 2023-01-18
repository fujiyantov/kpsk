<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    use HasFactory;

    public const PENDING = 1;
    public const ACCEPT = 2;
    public const REJECT = 3;
    public const FINISH = 4;
    public const EXPIRED = 5;

    protected $fillable = [
        'patient_id',
        'psikolog_id',
        'topic_id',
        'date',
        'time',
        'type',
        'diagnosis',
        'status',
        'meet_at',
        'no_telp',
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
