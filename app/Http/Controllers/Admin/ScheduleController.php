<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!in_array($user->role_id, [3])) {
            abort(403);
        }

        if (request()->ajax()) {
            $query = Schedules::latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {

                    $verifikasi = '
                            <form action="#" method="POST" onsubmit="return confirm(' . "'Anda akan ubah ini?'" . ')">
                                    ' . csrf_field() . '
                                    <button class="btn btn-warning text-black btn-xs">
                                        <i class="fa fa-pen"></i> &nbsp; Ubah 
                                    </button>
                                </form>
                            ';



                    $deleteBtn = '<form action="#" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>';

                    if ($item->status == 1) {
                        $deleteBtn = '';
                    }

                    return $verifikasi . '
                    ' . $deleteBtn . '
                    ';
                })
                ->addColumn('profile', function ($item) {

                    return '<div class="d-flex align-items-center">
                                <img class="img img-fluid" width="75" src="' . $item->patient->profile . '" />
                            </div>';
                })
                ->addColumn('patient', function ($item) {

                    return $item->patient->name;
                })
                ->addColumn('topic', function ($item) {
                    return $item->topic->title;
                })
                ->addColumn('type', function ($item) {
                    $type = 'online';
                    if ($item->type == 1) {
                        $type = 'offline';
                    }

                    return $type;
                })
                ->addColumn('status', function ($item) {
                    $status = 'diajukan';
                    if ($item->status == 2) {
                        $status = 'proses';
                    }

                    if ($item->status == 3) {
                        $status = 'selesai';
                    }

                    return $status;
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'profile', 'patient', 'type', 'status', 'topic'])
                ->make();
        }

        return view('pages.admin.schedules.index');
    }
}
