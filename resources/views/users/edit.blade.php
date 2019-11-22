@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row">
                    <div class="col"><h4>{{ __('Edit User Details') }}</h4></div>
                </div>
            </section>

            <section class="my-4">
                <form action="{{ route('users.update', $user) }}" method="post">
                    @csrf @method('put')

                    <div class="form-group">
                        <label for="">{{ __('Name') }}</label>
                        <input class="form-control @if ($errors->has('name')) is-invalid @endif" type="text" name="name" value="{{ old('name', $user->name) }}" autofocus>
                        @if ($errors->has('name'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Email') }}</label>
                        <input class="form-control @if ($errors->has('email')) is-invalid @endif" type="email" name="email" value="{{ old('email', $user->email) }}">
                        @if ($errors->has('email'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Roles') }}</label>
                        <div class="custom-control custom-checkbox">
                            @forelse ($roles as $role)
                                <div>
                                    <input type="checkbox" class="custom-control-input  @if ($errors->has('roles')) is-invalid @endif" id="{{ $role->id }}" name="roles[]" value="{{ $role->id }}"  {{ in_array($role->id, old('roles', $user->roles->modelKeys()))  ? 'checked' : null }}>
                                    <label class="custom-control-label" for="{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @empty
                                <div>
                                    {{ __('There is no data.') }}
                                </div>
                            @endforelse
                        </div>
                        @if ($errors->has('roles'))
                            <div class="small text-danger">
                                {{ $errors->first('roles') }}
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                </form>
            </section>

        </div>
    </div>
</div>
@endsection
