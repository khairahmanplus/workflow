@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <section class="my-4">
                <div class="row">
                    <div class="col"><h4>{{ __('New User') }}</h4></div>
                </div>
            </section>

            <section class="my-4">
                <form action="{{ route('users.store') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="">{{ __('Name') }}</label>
                        <input class="form-control @if ($errors->has('name')) is-invalid @endif" type="text" name="name" value="{{ old('name') }}" autofocus>
                        @if ($errors->has('name'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Email') }}</label>
                        <input class="form-control @if ($errors->has('email')) is-invalid @endif" type="email" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Password') }}</label>
                        <input class="form-control @if ($errors->has('password')) is-invalid @endif" type="password" name="password" value="{{ old('password') }}">
                        @if ($errors->has('password'))
                            <div class="small invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Password Confirmation') }}</label>
                        <input class="form-control @if ($errors->has('password')) is-invalid @endif" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Roles') }}</label>
                        <div class="custom-control custom-checkbox">
                            @forelse ($roles as $role)
                                <div>
                                    <input type="checkbox" class="custom-control-input  @if ($errors->has('roles')) is-invalid @endif" id="{{ $role->id }}" name="roles[]" value="{{ $role->id }}"  {{ in_array($role->id, old('roles', [])) ? 'checked' : null }}>
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

                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </form>
            </section>

        </div>
    </div>
</div>
@endsection
