<?php

namespace App\Http\Controllers\Admin;

use App\Models\Topics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TopicController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (request()->ajax()) {
            $query = Topics::latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                            <form action="' . route('topics.edit', [$item->id]) . '" method="GET">
                                <button class="btn btn-outline-success p-2 btn-xs">
                                        <i class="fa fa-pen"></i> &nbsp; Ubah 
                                    </button>
                                </form>
                            ';
                })
                ->addColumn('action_del', function ($item) {
                    return '<form action="' . route('topics.destroy', [$item->id]) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger p-2 btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>';
                })
                ->addColumn('image', function ($item) {

                    $imageLink = Storage::url('/assets/images/' . $item->image);
                    if (substr($item->image, 0, 5) == 'https') {
                        $imageLink = $item->image;
                    }
                    return '<div class="d-flex align-items-center">
                                <img class="img img-fluid" width="75" src="' . $imageLink . '" />
                            </div>';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'image', 'action_del'])
                ->make();
        }

        return view('pages.admin.topics.index');
    }

    public function create()
    {
        return view('pages.admin.topics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            // 'category_id' => 'required|numeric|min:0',
            'image' => 'required|file|max:2000',
            'description' => 'nullable|string',
        ]);

        if ($request->file('image')) {
            $imageFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('assets/images', $imageFileName);
        }

        Topics::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'image' => $imageFileName,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('topics.index')
            ->with('success', 'Sukses! 1 Data Berhasil Ditambahkan');
    }

    public function edit(Request $request, $id)
    {
        $resource = Topics::findOrFail($id);
        return view('pages.admin.topics.edit', [
            'resource' => $resource
        ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string',
            // 'category_id' => 'required|numeric|min:0',
            'image' => 'file|max:2000',
            'description' => 'nullable|string',
        ]);

        $resource = Topics::findOrFail($id);

        if ($request->file('image')) {
            $imageFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('assets/images', $imageFileName);
            $resource->image = $imageFileName;
        }

        $resource->title = $request->title;
        $resource->category_id = $request->category_id;
        $resource->description = $request->description;
        $resource->save();

        return redirect()
            ->route('topics.index')
            ->with('success', 'Sukses! 1 Data Berhasil Diperbaharui');
    }

    public function destroy(Request $request, $id)
    {
        $resource = Topics::findOrFail($id);
        $resource->delete();

        return redirect()
            ->route('topics.index')
            ->with('success', 'Sukses! 1 Data Berhasil Dihapus');
    }
}
