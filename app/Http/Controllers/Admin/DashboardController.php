<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Schedules;
use App\Models\Topics;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $topics = Topics::get();
        $article = News::get()->count();
        $mahasiswa = User::where('role_id', 4)->get()->count(); // mahasiswa
        $mahasiswa = Schedules::get()->count();

        $topicName = [];
        $topicData = [];
        $topicColor = [];
        
        foreach ($topics as $topic) {
            $topicName[] = $topic->title;
            $topicData[] = $topic->schedules->count();
            $topicColor[] = 'rgba(0,172,105,1)';
        }
        
        return view('pages.admin.dashboard',[
            'topic' => $topics->count(),
            'article' => $article,
            'mahasiswa' => $mahasiswa,
            'topicName' => $topicName,
            'topicData' => $topicData,
            'topicColor' => $topicColor,
        ]);
    }
}
