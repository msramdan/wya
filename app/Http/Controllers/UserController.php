<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\{StoreUserRequest, UpdateUserRequest};
use App\Models\Hospital;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Path for user avatar file.
     *
     * @var string
     */
    protected $avatarPath = '/uploads/images/avatars/';

    public function __construct()
    {
        $this->middleware('permission:user view')->only('index', 'show');
        $this->middleware('permission:user create')->only('create', 'store');
        $this->middleware('permission:user edit')->only('edit', 'update');
        $this->middleware('permission:user delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $users =
                DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('users.avatar', 'users.name', 'users.email', 'users.no_hp', 'users.id', 'roles.name as nama_roles')
                ->get();
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    return $row->nama_roles;
                })
                ->addColumn('avatar', function ($row) {
                    if ($row->avatar == null) {
                        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($row->email))) . '&s=500';
                    }
                    return asset($this->avatarPath . $row->avatar);
                })
                ->addColumn('action', 'users.include.action')
                ->toJson();
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hospitals = Hospital::all();
        return view('users.create', compact('hospitals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $attr = $request->validated();
        if ($request->file('avatar') && $request->file('avatar')->isValid()) {
            $filename = $request->file('avatar')->hashName();
            $folder = public_path($this->avatarPath);

            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            try {
                Image::make($request->file('avatar')->getRealPath())
                    ->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->save($folder . $filename);
            } catch (\Throwable $th) {
                // Handle error
            }

            $attr['avatar'] = $filename;
        }

        $attr['password'] = bcrypt($request->password);
        $user = User::create($attr);
        $user->assignRole($request->role);
        if ($request->has('hospitals')) {
            $userId = $user->id;
            $hospitals = $request->input('hospitals');
            $currentTimestamp = now();
            foreach ($hospitals as $hospitalId) {
                DB::table('user_access_hospital')->insert([
                    'user_id' => $userId,
                    'hospital_id' => $hospitalId,
                    'created_at' => $currentTimestamp,
                    'updated_at' => $currentTimestamp
                ]);
            }
        }
        Alert::toast('The user was created successfully.', 'success');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('roles:id,name');

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->load('roles:id,name');
        $hospitals = DB::table('hospitals')->get();
        $userHospitalIds = DB::table('user_access_hospital')
            ->where('user_id', $user->id)
            ->pluck('hospital_id')
            ->toArray();

        return view('users.edit', compact('user', 'hospitals', 'userHospitalIds'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $attr = $request->validated();

        // Handle avatar update
        if ($request->file('avatar') && $request->file('avatar')->isValid()) {
            $filename = $request->file('avatar')->hashName();

            // If folder doesn't exist, then create folder
            if (!file_exists($folder = public_path($this->avatarPath))) {
                mkdir($folder, 0777, true);
            }

            // Intervention Image
            Image::make($request->file('avatar')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path($this->avatarPath) . $filename);

            // Delete old avatar from storage
            if ($user->avatar != null && file_exists($oldAvatar = public_path($this->avatarPath . $user->avatar))) {
                unlink($oldAvatar);
            }

            $attr['avatar'] = $filename;
        } else {
            $attr['avatar'] = $user->avatar;
        }

        // Handle password update
        if (empty($request->password)) {
            unset($attr['password']);
        } else {
            $attr['password'] = bcrypt($request->password);
        }

        // Update user information
        $user->update($attr);

        // Update user role
        $user->syncRoles($request->role);

        // Sync hospitals
        $hospitals = $request->input('hospitals', []);

        // Remove existing hospital associations
        DB::table('user_access_hospital')->where('user_id', $user->id)->delete();

        // Add new hospital associations
        foreach ($hospitals as $hospitalId) {
            DB::table('user_access_hospital')->insert([
                'user_id' => $user->id,
                'hospital_id' => $hospitalId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()
            ->route('users.index')
            ->with('success', __('The user was updated successfully.'));
    }


    public function destroy(User $user)
    {
        if ($user->avatar != null && file_exists($oldAvatar = public_path($this->avatarPath . $user->avatar))) {
            unlink($oldAvatar);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', __('The user was deleted successfully.'));
    }
}
