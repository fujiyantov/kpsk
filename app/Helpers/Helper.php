<?php

use App\Models\Chat;
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

/* CHAT */

function notifCountChat()
{

    $user = Auth::user();
    $query = Chat::whereNull('psikolog_id');
    $count = $query->where('is_read', 0)->count();

    return $count;
}

function notifCountMessageChat()
{

    $user = Auth::user();
    $query = Chat::whereNull('psikolog_id');
    $collections = $query->where('is_read', 0)->orderBy('created_at', 'desc')->get();

    return $collections;
}

function sendNotificationFirebase($body, $user)
{
    // $token = 'AAAA55mSYWI:APA91bEKl0IPcdMD-MG3vObO8035InOz_SeL1_JPA7u1INCe8lurmsjqWuF96eqtMdctU8qjtFTd8GUl6PGOB_NygQaMXHM2m9RkyL2tx4B9V0vJW7cJV_YcwEy-qoXHfOtpRmCCVsCH';
    $token = 'AAAABg5Y1MA:APA91bFSwnCZImjG9Y_Dz69_BnS3Aw0eMf8aE7gTrss2WeTfz-PIXnEpyloNnmc7Gw8nj_POgANBbuCz9jeKdwYzG_gW3bLuvu4IfOLsDbpPEURi7FNXTwK7bQDSdvWTzVc3Q791d6Zt'; //psikolog
    $headers = array(
        // 'Authorization: key=' . ENV('FIREBASETOKEN'),
        'Authorization: key=' . $token,
        'Content-Type: application/json'
    );

    $tokeUser = 'dKYZFiq4SkKksn_0NBsmtN:APA91bEvZ_YWqK2aBkTpzdIMC0x-l6M8q9Qt_ldI9wCOnn7fomPFVQeDSLH92AnldcYDUv4xuux-ywovAhy0AGWXHvlzBDXZ1RXRr0AtgcmOz2DRP6fXt-eXWbvRclxyQZfePlBJWOIW';
    $data = array(
        "to" => $user->fcm_token,
        'notification' => [
            "title" => 'PSIKOLOG',
            "body" => $body,
        ],
        "data" => [
            'slug' => 'schedules'
        ]
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $result = curl_exec($ch);
    curl_close($ch);
}
