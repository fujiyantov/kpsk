<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleCollection;
use App\Models\Schedules;
use App\Models\Topics;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\RequiredIf;
use Symfony\Component\HttpFoundation\Response;

class ConsultationController extends Controller
{
    private const OFFLINE = 0;
    private const ONLINE = 1;

    public function index(Request $request)
    {
        $user = auth()->guard('api')->user();
        $type = $request->get('type');
        $status = $request->get('status');

        $collections = Schedules::when(isset($type), function ($query) use ($type) {
            $query->where('type', $type);
        })
            ->whereIn('status', [4, 5])
            ->where('patient_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response(new ScheduleCollection($collections), Response::HTTP_OK);
    }

    public function pending(Request $request)
    {
        $user = auth()->guard('api')->user();
        $type = $request->get('type');
        $status = $request->get('status');

        $collections = Schedules::whereIn('status', [1,2,3])
            ->where('patient_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response(new ScheduleCollection($collections), Response::HTTP_OK);
    }

    /**
     * Store newly a resource
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            Validator::validate($request->all(), [
                'topic_id' => 'required|numeric|min:0',
                // 'date' => 'required|string',
                // 'time' => 'required|string',
                'type' => 'required|numeric|min:0|max:1',
            ]);

            $topic = Topics::where('id', $request->input('topic_id'))->firstOrFail();

            $date = $request->input('date');
            $time = $request->input('time');

            /* if ($request->input('topic_id') == self::ONLINE) {
                $date = Carbon::now()->toDateString();
                $time = Carbon::now()->toTimeString();
            } */

            $resource = new Schedules();
            $resource->patient_id   = Auth::user()->id;
            $resource->psikolog_id  = $topic->psikolog_id;
            $resource->topic_id     = $request->input('topic_id');
            $resource->date         = $date;
            $resource->time         = $time;
            $resource->type         = $request->input('type');
            $resource->status       = 1;
            $resource->meet_at      = $request->meet_at;
            $resource->no_telp      = $request->no_telp;
            $resource->save();

            return response()->json(['message' => 'schedule has been created'], Response::HTTP_CREATED);
        } catch (\ModelNotFoundException $e) {
            Log::info($e);
            throw $e;
        } catch (\Exception $e) {
            Log::info($e);
            throw $e;
        }
    }

    public function getSummeryTopic(Request $request)
    {
        $user = auth()->guard('api')->user();
        $collections = Topics::all();

        $datas = [];
        if (count($collections) > 0) {
            foreach ($collections as $collection) {
                $datas[] = [
                    'topic' => $collection->title,
                    'total' => $collection->schedules->where('patient_id', $user->id)->count(),
                ];
            }
        }

        return response()->json([
            'data' => $datas
        ], Response::HTTP_OK);
    }
}
