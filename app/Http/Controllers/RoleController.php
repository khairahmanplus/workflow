<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Authorization\Permission;
use App\Models\Authorization\Role;
use App\Rules\Password\ValidatePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate();

        return view('roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();

        return view('roles.create', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => [
                'required'
            ],
            'has_all_permissions'   => [
                'nullable'
            ],
            'permissions'           => [
                'required_without:has_all_permissions',
            ],
            'permissions.*'         => [
                Rule::in(Permission::pluck('id'))
            ]
        ]);

        $role = Role::create([
            'name'  => $request->input('name'),
            'label' => Str::snake($request->input('name'))
        ]);

        if (! $request->has('has_all_permissions')) {
            $role->permissions()->attach($request->input('permissions'));
        }

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully saved to the database.'));

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Authorization\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $role->loadMissing('permissions');

        return view('roles.show', [
            'role' => $role
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Authorization\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $role->loadMissing('permissions');

        $permissions = Permission::get();

        return view('roles.edit', [
            'role'          => $role,
            'permissions'   => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Authorization\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'                  => [
                'required'
            ],
            'has_all_permissions'   => [
                'nullable'
            ],
            'permissions'           => [
                'required_without:has_all_permissions',
            ],
            'permissions.*'         => [
                Rule::in(Permission::pluck('id'))
            ]
        ]);

        $role->update([
            'name'  => $request->input('name'),
            'label' => Str::snake($request->input('name'))
        ]);

        $role->permissions()->detach();

        if (! $request->has('has_all_permissions')) {
            $role->permissions()->attach($request->input('permissions'));
        }

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully updated to the database.'));

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Authorization\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                new ValidatePassword
            ],
        ]);

        if ($validator->fails()) {

            $request->merge([
                'action'    => $request->url()
            ]);

            return back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($role->hasAllPermissions()) {
            session()->flash('app::class', 'alert-danger');
            session()->flash('app::message', __('Cannot delete this role as it is a super administrator role.'));

            return back();
        }

        $role->permissions()->detach();

        $role->delete();

        session()->flash('app::class', 'alert-danger');
        session()->flash('app::message', __('Data successfully deleted from the database.'));

        return back();
    }
}
