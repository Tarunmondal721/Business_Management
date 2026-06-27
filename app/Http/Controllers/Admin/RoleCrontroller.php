<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleCrontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        abort_unless(Auth::guard('web')->user()->can('role.view'), 404);

        $roles = Role::with('permissions')->get();


       return view('admin.role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(Auth::guard('web')->user()->can('role.create'), 404);

        $permissions = Permission::where('guard_name', 'web')
            ->get() // first get collection
            ->groupBy(function ($perm) {
                return explode('.', $perm->name)[0];
            });
            // dd($permissions);

        return view('admin.role.create', compact('permissions'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_unless(Auth::guard('web')->user()->can('role.create'), 404);
        // dd($request->all());
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array|required',
        ]);

        if (!isset($request->status)) {
            $status = 0;
        }
        $role = Role::create([
            'name' => strtolower($request->name),
            'guard_name' => 'web',
            'status' => $status ?? 1,
        ]);

        // Assign permissions
        $role->syncPermissions($request->permissions);
        Toastr::success('Role created successfully!');

        return redirect()->route('admin.role.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return response()->json([
            'permissions' => $role->permissions->pluck('name')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_unless(Auth::guard('web')->user()->can('role.edit'), 404);
        $role = Role::findOrFail($id);

        $permissions = Permission::where('guard_name', 'web')->get()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_unless(Auth::guard('web')->user()->can('role.edit'), 404);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'array|required',
        ]);

        $role = Role::findOrFail($id);
        if (!isset($request->status)) {
            $status = 0;
        }

        $role->update([
            'name' => strtolower($request->name),
            'guard_name' => 'web',
            'status' => $status ?? 1,
        ]);

        $role->syncPermissions($request->permissions);
        Toastr::success('Role updated successfully!');

        return redirect()->route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_unless(Auth::guard('web')->user()->can('role.delete'), 404);

        $role = Role::findOrFail($id);
        if ($role->name === 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'You cannot delete the Super Admin role!'
            ]);
        }

        $role->permissions()->detach();
        $role->delete();

        Toastr::success('Role and its assigned permissions deleted successfully!');
        return redirect()->route('admin.role.index');
    }


    public function getData(Request $request)
    {
        $query = Role::with('permissions');

        return DataTables::of($query)
            ->addIndexColumn()

            // Bold Index Column
            ->editColumn('DT_RowIndex', function ($index) {
                return "<b>$index</b>";
            })

            // ucfirst Role name
            ->editColumn('name', function ($role) {
                return ucfirst($role->name);
            })

            ->addColumn('permissions', function ($role) {
                $perms = $role->permissions->take(5)->pluck('name');

                $labels = $perms->map(function ($p) {
                    return "<span class='badge bg-secondary me-1'>$p</span>";
                })->implode(' ');

                if ($role->permissions->count() > 5) {
                    $labels .= "<span class='badge bg-warning'>+" . ($role->permissions->count() - 5) . " more</span>";
                }

                return $labels;
            })


            ->addColumn('created_at', function ($role) {
                return $role->created_at->format('Y-m-d');
            })
            ->addColumn('updated_at', function ($role) {
                return $role->updated_at->format('Y-m-d');
            })

            ->addColumn('actions', function ($role) {
                return '
                <button
            class="btn btn-sm btn-outline-primary viewRoleBtn"
            data-id="' . $role->id . '"
            data-name="' . ucfirst($role->name) . '"
            title="View Role">
            <i class="lni lni-eye"></i>
        </button>
            <a href="' . route('admin.role.edit', $role->id) . '" class="btn btn-sm btn-outline-primary" title="Edit Role">
                <i class="lni lni-pencil-alt"></i>
            </a>
           <button data-id="' . $role->id . '" class="btn btn-sm btn-outline-danger deleteBtn" title="Delete Role">
                <i class="lni lni-trash-can"></i>
            </button>
        ';
            })
            ->rawColumns(['DT_RowIndex', 'permissions', 'actions'])
            ->make(true);
    }
}
