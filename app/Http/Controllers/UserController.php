<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Authorization\Role;
use App\Rules\Password\ValidatePassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        $users = User::paginate();

        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();

        return view('users.create', [
            'roles' => $roles
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
            'name'      => [
                'required',
                'string',
                'max:255'
            ],
            'email'     => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'password'  => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
        ]);

        $user = User::create([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password')),
        ]);

        if ($request->has('roles')) {
            $user->roles()->attach($request->input('roles'));
        }

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully saved to the database.'));

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->loadMissing('roles');

        return view('users.show', [
            'user'  => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->loadMissing('roles');

        $roles = Role::get();

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => [
                'required',
                'string',
                'max:255'
            ],
            'email'     => [
                'required',
                'string',
                'email',
                'max:255',
            ],
        ]);

        $user->update([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
        ]);

        $user->roles()->detach();

        if ($request->has('roles')) {
            $user->roles()->attach($request->input('roles'));
        }

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully updated to the database.'));

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
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

        if ($user->hasRoleAdministrator()) {
            session()->flash('app::class', 'alert-danger');
            session()->flash('app::message', __('Cannot delete user as the user has super administrator role.'));

            return back();
        }

        $user->roles()->detach();

        $user->delete();

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully deleted from the database.'));

        return back();
    }
}
