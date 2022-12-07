<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (request()->ajax()) {
            $query = News::latest()->get();

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
                ->addColumn('image', function ($item) {

                    return '<div class="d-flex align-items-center">
                                <img class="img img-fluid" width="75" src="' . $item->image . '" />
                            </div>';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'image'])
                ->make();
        }

        return view('pages.admin.news.index');
    }
}
