<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (request()->ajax()) {
            $query = News::latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {

                    $editBtn = '
                            <form action="' . route('news.edit', [$item->id]) . '" method="GET">
                                    <button class="btn btn-warning text-black btn-xs">
                                        <i class="fa fa-pen"></i> &nbsp; Ubah 
                                    </button>
                                </form>
                            ';

                    $deleteBtn = '<form action="' . route('news.destroy', [$item->id]) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>';

                    if ($item->status == 1) {
                        $deleteBtn = '';
                    }

                    return $editBtn . '
                    ' . $deleteBtn . '
                    ';
                })
                ->addColumn('image', function ($item) {

                    $imageLink = Storage::url('/assets/images/' . $item->image);
                    if (substr($item->image, 0, 5) == 'https') {
                        $imageLink = $item->image;
                    }
                    return '<div class="d-flex align-items-center">
                                <img class="img img-thumbnail img-fluid" width="75" src="' . $imageLink . '" />
                            </div>';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'image'])
                ->make();
        }

        return view('pages.admin.news.index');
    }

    public function create()
    {
        return view('pages.admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'image' => 'required|file|max:2000',
            'content' => 'nullable|string',
        ]);

        if ($request->file('image')) {
            $imageFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('assets/images', $imageFileName);
        }

        News::create([
            'title' => $request->title,
            'image' => $imageFileName,
            'content' => $request->content,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()
            ->route('news.index')
            ->with('success', 'Sukses! 1 Data Berhasil Ditambahkan');
    }

    public function edit(Request $request, $id)
    {
        $resource = News::findOrFail($id);
        return view('pages.admin.news.edit', [
            'resource' => $resource
        ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string',
            'image' => 'file|max:2000',
            'content' => 'nullable|string',
        ]);

        $resource = News::findOrFail($id);

        if ($request->file('image')) {
            $imageFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('assets/images', $imageFileName);
            $resource->image = $imageFileName;
        }

        $resource->title = $request->title;
        $resource->content = $request->content;
        $resource->created_by = Auth::user()->id;
        $resource->save();

        return redirect()
            ->route('news.index')
            ->with('success', 'Sukses! 1 Data Berhasil Diperbaharui');
    }

    public function destroy(Request $request, $id)
    {
        $resource = News::findOrFail($id);
        $resource->delete();

        return redirect()
            ->route('news.index')
            ->with('success', 'Sukses! 1 Data Berhasil Dihapus');
    }
}
