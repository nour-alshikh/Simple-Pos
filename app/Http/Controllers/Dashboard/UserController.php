<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(["permission:users_create"])->only(["create", 'store']);
        $this->middleware(["permission:users_read"])->only("index");
        $this->middleware(["permission:users_update"])->only(["update", 'update']);
        $this->middleware(["permission:users_delete"])->only("destroy");
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->when($request->search, function ($que) use ($request) {
            return $que->where("first_name", 'like', '%' . $request->search . '%')
                ->orWhere("last_name", 'like', '%' . $request->search . '%');
        })->latest()->paginate(1);


        // $users = User::whereRoleIs('admin')->where(function ($q) use ($request) {
        //     return $q->when($request->search, function ($query) use ($request) {
        //         return $query->where('first_name', 'like', '%' . $request->search . '%')
        //             ->orWhere('last_name', 'like', '%' . $request->search . '%');
        //     });
        // })->latest()->paginate(1);

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->permissions);
        // try {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required',
        ]); //end validation


        $request_data = $request->except('password', 'password_confirmation', 'permissions', 'image');

        $request_data['password'] = bcrypt($request->password);


        if ($request->image) {
            // create new image instance
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($request->image); // 800 x 600

            // scale down to fixed width
            $image->scaleDown(width: 200)->save(public_path('uploads/user_images/' . $request->image->hashName())); // 300 x 200
            $request_data['image'] = $request->image->hashName();
        }


        $user = User::create($request_data);
        $user->addRole("admin");

        // dd($user->id);

        $permissionNames = $request->permissions;
        $permissionIds = Permission::whereIn('name', $permissionNames)->pluck('id');
        $user->permissions()->sync($permissionIds);



        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('users.index');
        // } catch (\Throwable $e) {
        //     return redirect()->back()->with(['error' => $e->getMessage()]);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // dd($user);
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'image' => 'image|nullable',
            'permissions' => 'required',

        ]); //end validation

        $request_data = $request->except('permissions', 'image');

        if ($request->image) {

            if ($user->image !== "default.png") {
                Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
            }

            // create new image instance
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($request->image); // 800 x 600

            // scale down to fixed width
            $image->scaleDown(width: 200)->save(public_path('uploads/user_images/' . $request->image->hashName())); // 300 x 200
            $request_data['image'] = $request->image->hashName();
        }

        $user->update($request_data);

        $permissionNames = $request->permissions;
        $permissionIds = Permission::whereIn('name', $permissionNames)->pluck('id');
        $user->permissions()->sync($permissionIds);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->image !== 'default.png') {
            Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
        }
        $user->delete();
        return redirect()->back();
    }
}
