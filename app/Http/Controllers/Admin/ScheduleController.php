<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\Topics;
use App\Models\Schedules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $param = $request->get('topic_id');
        if (!in_array($user->role_id, [2, 3])) {
            abort(403);
        }

        if (request()->ajax()) {

            if (isset($param)) {
                $query = Schedules::where('topic_id', $param)->latest()->get();
            } else {
                $query = Schedules::latest()->get();
            }

            return Datatables::of($query)
                ->addColumn('action', function ($item) {

                    return '
                            <form action="' . route('schedules.show', [$item->id]) . '" method="GET">
                                    <button class="btn btn-outline-success p-2 btn-xs">
                                        <i class="fa fa-eye"></i> &nbsp; Lihat Detail 
                                    </button>
                                </form>
                            ';
                })
                ->addColumn('profile', function ($item) {

                    return '<div class="d-flex align-items-center mb-2 mt-1">
                                <img class="img img-fluid rounded-circle" width="75" src="' . $item->patient->profile . '" />
                            </div>';
                })
                ->addColumn('patient', function ($item) {
                    $faculty = isset($item->patient->faculty) ? $item->patient->faculty->title : '-';
                    $studyProgram =  isset($item->patient->studyProgram) ? $item->patient->studyProgram->title : '-';
                    return '
                        
                            <h5 class="card-title">' . $item->patient->name . '</h5>
                            <small class="card-subtitle mb-2 text-muted" style="font-size:10px">' . ucwords($faculty) . '</small></br>
                            <small class="card-subtitle mb-2 text-muted" style="font-size:10px">' . $studyProgram . '</small>
                        
                    ';
                })
                // ->addColumn('faculty', function ($item) {
                //     return isset($item->patient->faculty) ? $item->patient->faculty->title : '-';
                // })
                // ->addColumn('study_program', function ($item) {
                //     return isset($item->patient->studyProgram) ? $item->patient->studyProgram->title : '-';
                // })
                ->addColumn('topic', function ($item) {
                    return $item->topic->title;
                })
                ->addColumn('type', function ($item) {
                    $type = 'Chat';
                    $typeIcon = 'video';

                    if ($item->type == 1) {
                        $type = 'Tatap Muka';
                        $typeIcon = 'smile';
                    }

                    return $type;
                })
                ->addColumn('status', function ($item) {
                    switch ($item->status) {
                        case Schedules::PENDING:
                            $status = 'Diajukan';
                            $bg = 'bg-warning';
                            break;

                        case Schedules::ACCEPT:
                            $status = 'Diterima';
                            $bg = 'bg-primary';
                            break;

                        case Schedules::REJECT:
                            $status = 'Ditolak';
                            $bg = 'bg-danger';
                            break;

                        case Schedules::FINISH:
                            $status = 'Selesai';
                            $bg = 'bg-success';
                            break;

                        case Schedules::EXPIRED:
                            $status = 'Expired';
                            $bg = 'bg-dark';
                            break;

                        default:
                            $status = '-';
                            $bg = '';
                            break;
                    }

                    return '<span class="badge ' . $bg . ' text-bold"">' . $status . '</span>';
                })
                ->addColumn('created_at', function ($item) {
                    return Carbon::parse($item->created_at)->format('d M Y H.i');
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'profile', 'patient', 'type', 'status', 'topic', 'created_at', /* 'faculty', 'study_program' */])
                ->make();
        }

        return view('pages.admin.schedules.index');
    }

    public function show(Request $request, $id)
    {
        $item = Schedules::findOrFail($id);
        if ($request->get('is_read') == true) {
            $item->is_read = 1;
            $item->save();
        }

        $chats = Chat::where('schedule_id', $id)->get();
        return view('pages.admin.schedules.show', compact('item', 'chats'));
    }

    public function update(Request $request, $id)
    {
        try {

            if (!in_array($request->status, [2, 3])) {
                throw new \Exception('status invalid', 422);
            }

            $item = Schedules::findOrFail($id);
            $item->status = $request->status;
            $item->description = $request->description;
            $item->save();

            $message = 'Selamat, jadwal konsultasi kamu telah disetujui, silahkan untuk datang pada waktu yang sudah ditentukan';
            if ($request->status == 3) {
                $message = 'Maaf, jadwal konsultasi kamu tidak dapat disetujui, silahkan untuk mencoba dilain waktu';
            }

            sendNotificationFirebase($message, $item->patient);

            return redirect()->back();
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function review(Request $request, $id)
    {
        try {

            if (!is_string($request->diagnosis)) {
                throw new \Exception('invalid format', 422);
            }

            $item = Schedules::findOrFail($id);
            if ($item->status != 2) {
                throw new \Exception('Jadwal konsultasi kamu masih dalam proses diajukan atau telah selesai', 422);
            }

            $item->diagnosis = $request->diagnosis;
            $item->status = Schedules::FINISH;
            $item->save();

            $message = 'Terima kasih, layanan konsultasi kamu telah selesai';

            sendNotificationFirebase($message, $item->patient);

            return redirect()->back();
        } catch (\Exception $th) {
            throw $th;
        }
    }

    /* public function chatAjax(Request $request, $id)
    {
        $item = Chat::where('schedule_id', $id)->orderBy('created_at', 'desc')->first();
        $response = '';

        if ($item) {
            $textAlign = $item->psikolog_id == Auth::user()->id ? "text-align:right" : "";
            $textName = $item->psikolog_id != Auth::user()->id ? $item->patient->full_name : 'You';
            $textDate = Carbon::parse($item->created_at)->diffForHumans();
            $textMessage = $item->messages;

            $response = '<li class="list-group-item"
                style="background: #F7F9FA; ' . $textAlign . '">
                <h6>' . $textName . '
                </h6>
                <i data-feather="clock"
                    style="width: 12px; vertical-align: middle"></i><small>
                    ' . $textDate . '</small>
                <br />
                <div
                    class="row ' . $textAlign . '>
                    <small class="text-muted">' . $textMessage . '</small>
                </div>
            </li>';
        }

        return $response;
    } */

    public function chatAjax(Request $request, $id)
    {
        $items = Chat::where('schedule_id', $id)->orderBy('id', 'asc')->get();
        $response = '';

        if ($items) {
            foreach ($items as $item) {
                $textAlign = $item->psikolog_id == Auth::user()->id ? "text-align:right" : "";
                $textName = $item->psikolog_id != Auth::user()->id ? $item->patient->full_name : 'You';
                $textDate = Carbon::parse($item->created_at)->addHour('7')->format('H:i');
                $textMessage = $item->messages;

                $response = '<div class=""><li class="list-group-item"
                style="background: #F7F9FA; ' . $textAlign . '">
                <h6>' . $textName . '
                </h6>
                <div
                    class="row mb-1" style="' . $textAlign . '">
                    <small>' . $textMessage . '</small>
                </div>
                <i data-feather="clock"
                    style="width: 12px; vertical-align: middle"></i><small class="text-muted">
                    ' . $textDate . '</small>
            </li></div>';

                echo $response;
            }
        }
    }

    public function chatAjaxStore(Request $request, $id)
    {
        $item = Schedules::findOrFail($id);
        $store = new Chat();
        $store->schedule_id = $id;
        $store->psikolog_id = $item->psikolog_id;
        if (Auth::user()->id != $item->psikolog_id) {
            $store->patient_id = $item->patient_id;
        }
        $store->messages = $request->msg;
        $store->save();

        $message = substr($request->msg, 0, 60) . '...';

        sendNotificationFirebase($message, $item->patient);

        return 201;
    }

    public function showChat(Request $request, $id)
    {
        $chat = Chat::findOrFail($id);
        if ($request->get('is_read') == true) {
            $chat->is_read = 1;
            $chat->save();
        }

        $item = Schedules::where('id', $chat->schedule_id)->firstOrFail();

        $chats = Chat::where('schedule_id', $id)->get();
        return view('pages.admin.schedules.show', compact('item', 'chats'));
    }

    public function rekap()
    {
        $topics = Topics::get();

        return view('pages.admin.schedules.rekap', compact('topics'));
    }
}
