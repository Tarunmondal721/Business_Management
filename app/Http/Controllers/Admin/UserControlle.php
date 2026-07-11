<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr as FacadesToastr;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserControlle extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->guard('web')->user()->can('user.view'), 404);
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }
    public function create(Request $request)
    {
        abort_unless(auth()->guard('web')->user()->can('user.create'), 404);
        $roles = Role::where('status', 1)->where('id', '!=', 1)->get();
        return view('admin.user.add_edit', compact('roles'));
    }

    public function edit(Request $request, String $id)
    {
        abort_unless(auth()->guard('web')->user()->can('user.edit'), 404);
        $user = User::findOrFail($id);
        // dd($user);
        $roles = Role::where('status', 1)->where('id', '!=', 1)->get();

        return view('admin.user.add_edit', compact('user', 'roles'));
    }

    public function destroy(Request $request,String $id)
    {
        abort_unless(auth()->guard('web')->user()->can('user.delete'), 404);

        $User = User::findOrFail($id);
        if($User->role_id == 1) {
            FacadesToastr::error('Super Admin can not be deleted');
            return back();
        }
        if($User->image && Storage::disk('public')->exists('users/' . $User->image)) {
            Storage::disk('public')->delete('seller_users/' . $User->image);
        }

        $User->delete();
        FacadesToastr::success('User deleted successfully.');
        return redirect()->route('admin.user.index');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->guard('web')->user()->can('user.create'), 404);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email,',

            'phone' => 'required|max:15',

            'role_name' => 'required',

            'status' => 'required|boolean',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'password' => 'required|confirmed|min:8',
            // 'address' => 'nullable|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errors' => $validator->errors(),
            ], 422);
        }

        $role = Role::where('name', $request->role_name)->first();

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->status = $request->status;
            $user->role_id = $role->id;
            $user->role_name = $request->role_name;
            // $user->address = $request->address;

            
            $user->password = bcrypt($request->password);
            $user->save();

            $user->assignRole($request->role_name);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('users', $image, $filename);
                $user->profile_image = $filename;
            }
            $user->save();
            DB::commit();
            return response()->json([
                'success' => 1,
                'message' => 'User created successfully.',
                'redirect' => route('admin.user.index'),
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user: ' . $e->getMessage());
            return response()->json([
                'success' => 0,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, String $id)
    {
        abort_unless(auth()->guard('web')->user()->can('user.edit'), 404);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email,'.$id,

            'phone' => 'required|max:15',

            'role_name' => 'required',

            'status' => 'required|boolean',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'password' => 'nullable|confirmed|min:8',
            // 'address' => 'nullable|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $role = Role::where('name', $request->role_name)->first();
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->status = $request->status;
            $user->role_id = $role->id;
            $user->role_name = $request->role_name;
            // $user->address = $request->address;
            $user->password = bcrypt($request->password);
            $user->save();

            $user->syncRoles($request->role_name);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('users', $image, $filename);
                $user->profile_image = $filename;
            }
            $user->save();
            DB::commit();
            return response()->json([
                'success' => 1,
                'message' => 'User Updated successfully.',
                'redirect' => route('admin.user.index'),
            ], 200);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error update user: ' . $e->getMessage());
            return response()->json([
                'success' => 0,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
