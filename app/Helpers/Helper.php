<?php

use App\Models\Letter;
use App\Models\LetterHistories;
use App\Models\Schedules;
use Illuminate\Support\Facades\Auth;

function notifCount()
{

    $user = Auth::user();
    $query = Schedules::where('psikolog_id', $user->id);
    $count = $query->where('is_read', 0)->count();

    return $count;
}

function notifCountMessage()
{

    $user = Auth::user();
    $query = Schedules::where('psikolog_id', $user->id);
    $collections = $query->where('is_read', 0)->orderBy('created_at', 'desc')->get();

    return $collections;
}
