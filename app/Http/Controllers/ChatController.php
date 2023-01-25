<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\Http\Resources\ChatCollection;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{
    public function index(Request $request, $id)
    {
        $collections = Chat::where('schedule_id', $id)->get();

        return response()->json(
            new ChatCollection($collections),
            Response::HTTP_OK
        );
    }
}
