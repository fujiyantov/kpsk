<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = [
        'schedule_id',
        'patient_id',
        'psikolog_id',
        'messages',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function psikolog()
    {
        return $this->belongsTo(User::class, 'psikolog_id');
    }
}
