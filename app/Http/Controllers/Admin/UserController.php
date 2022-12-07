<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = User::where('id', '!=', 1)->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#updateModal' . $item->id . '">
                            <i class="fas fa-edit"></i> &nbsp; Edit
                        </a>
                        <form action="' . route('user.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini secara permanen dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                })
                ->editColumn('name', function ($item) {
                    return $item->profile ?
                        '<div class="d-flex align-items-center">
                                    <div class="avatar me-2"><img class="avatar-img img-fluid" src="' . Storage::url($item->profile) . '" /></div>' .
                        $item->name . '
                                </div>'
                        : '<div class="d-flex align-items-center">
                                    <div class="avatar me-2"><img class="avatar-img img-fluid" src="https://ui-avatars.com/api/?name=' . $item->name . '" /></div>' .
                        $item->name . '
                                </div>';
                })
                ->editColumn('position', function ($item) {
                    switch ($item->role_id) {
                        case '2':
                            $strname = 'Dekan';
                            break;

                        case '3':
                            $strname = 'Psiklog';
                            break;

                        case '4':
                            $strname = 'User';
                            break;

                        default:
                            $strname = 'Dekan';
                            break;
                    }
                    return $strname;
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'name'])
                ->make();
        }

        $positions = collect([
            [
                'id' => 2,
                'name' => 'dekan',
            ],
            [
                'id' => 3,
                'name' => 'psikolog'
            ],
            [
                'id' => 4,
                'name' => 'patient',
            ]
        ]);

        $users = User::where('id', '!=', 1)->get();

        return view('pages.admin.user.index', [
            'positions' => $positions,
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('pages.admin.user.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'position_id' => 'required|numeric|min:1',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['role_id'] = $validatedData['position_id'];

        User::create($validatedData);

        return redirect()
            ->route('user.index')
            ->with('success', 'Sukses! Data Pengguna Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        return view('pages.admin.user.index', [
            'user' => $user
        ]);
    }

    public function edit($id)
    {
        $item = User::findOrFail($id);

        return view('pages.admin.user.edit', [
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'position_id' => 'required|numeric|min:1',
            'password' => 'nullable|min:5|max:255',
        ]);

        $item = User::findOrFail($id);
        $item->name = $request->name;
        $item->email = $request->email;
        $item->role_id = $request->position_id;
        if (isset($request->password)) {

            $item->password = Hash::make($request->password);
        }
        $item->save();

        return redirect()
            ->route('user.index')
            ->with('success', 'Sukses! Data Pengguna telah diperbarui');
    }

    public function destroy($id)
    {
        $item = User::findorFail($id);

        Storage::delete($item->profile);

        $item->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'Sukses! Data Pengguna telah dihapus');
    }

    public function upload_profile(Request $request)
    {
        $validatedData = $request->validate([
            'profile' => 'required|image|file|max:1024',
        ]);

        $id = $request->id;
        $item = User::findOrFail($id);

        if ($request->file('profile')) {
            Storage::delete($item->profile);
            $item->profile = $request->file('profile')->store('assets/profile-images');
        }

        $item->save();

        return redirect()
            ->route('user.index')
            ->with('success', 'Sukses! Photo Pengguna telah diperbarui');
    }

    public function change_password()
    {
        return view('pages.admin.user.change-password');
    }
}
