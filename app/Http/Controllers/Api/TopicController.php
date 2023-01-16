<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Models\Topics;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $collections = Topics::get();
        
        return response()->json(
            new TopicCollection($collections),
            Response::HTTP_OK
        );
    }

    public function show(Request $request, $id)
    {
        try {
            $resource = Topics::findOrFail($id);

            return response()->json(
                new TopicResource($resource),
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
