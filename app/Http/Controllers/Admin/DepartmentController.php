<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Department;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Department::latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#updateModal' . $item->id . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('department.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                })
                ->addColumn('proposal', function ($item) {
                    return '
                        <a class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#updateModal' . $item->id . '">
                            Lihat disini
                        </a>
                    ';
                })
                ->addColumn('status', function ($item) {
                    return $item->status == 1 ? 'verifikasi' : 'validasi';
                })
                ->addColumn('tanggal', function ($item) {
                    return Carbon::parse($item->tanggal)->format("d/m/Y");
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'proposal', 'status', 'tanggal'])
                ->make();
        }
        $department = Department::all();

        return view('pages.admin.department.index', [
            'department' => $department
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'perihal' => 'required',
        ]);

        Department::create([
            'name' => $request->name,
            'perihal' => $request->perihal,
        ]);

        return redirect()
            ->route('department.index')
            ->with('success', 'Sukses! 1 Data Berhasil Disimpan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'perihal' => 'required',
        ]);

        Department::where('id', $id)
            ->update([
                'name' => $request->name,
                'perihal' => $request->perihal,
            ]);

        return redirect()
            ->route('department.index')
            ->with('success', 'Sukses! 1 Data telah diperbarui');
    }

    public function destroy($id)
    {
        $item = Department::findorFail($id);

        $item->delete();

        return redirect()
            ->route('department.index')
            ->with('success', 'Sukses! 1 Data Berhasil Dihapus');
    }
}
