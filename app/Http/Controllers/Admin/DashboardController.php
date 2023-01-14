<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Topics;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $topics = Topics::get();
        $article = News::get()->count();
        $mahasiswa = User::where('role_id', 3)->get()->count(); // mahasiswa

        $collections = Topics::all();

        $datas = [];
        $topicName = [];
        $topicData = [];
        $topicColor = [];
        foreach ($topics as $topic) {
            // $datas[] = [
            //     'topics' => $topic->title,
            //     'total' => $topic->schedules->count(),
            // ];

            $topicName[] = $topic->title;
            $topicData[] = $topic->schedules->count();
            $topicColor[] = 'rgba(0,172,105,1)';
        }
        // dd($topicName, $topicData);
        $aa = 'aaa';
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
