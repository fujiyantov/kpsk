<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $collections = News::latest()->get();

        return response()->json(
            new NewsCollection($collections),
            Response::HTTP_OK
        );
    }

    public function show(Request $request, $id)
    {
        try {
            $resource = News::findOrFail($id);

            return response()->json(
                new NewsResource($resource),
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
