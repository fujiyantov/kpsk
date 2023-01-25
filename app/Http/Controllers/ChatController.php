<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Schedules;
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

    public function chatStoreAPI(Request $request)
    {
        // return $request->schedule_id;
        // $user = Auth::user()->id;
        $item = Schedules::findOrFail($request->schedule_id);
        $store = new Chat();
        $store->schedule_id = $request->schedule_id;
        $store->patient_id = $item->patient_id;
        $store->messages = $request->messages;
        $store->save();

        return 200;
    }
}
